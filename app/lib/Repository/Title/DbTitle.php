<?php namespace Lib\Repository\Title;

use Carbon\Carbon;
use Lib\Services\Db\Writer;
use Intervention\Image\Image;
use Lib\Services\Images\ImageSaver as Imgs;
use Char, Actor, Title, Helpers, Event, App, Link, Language;
use Lib\Repository\Data\DataRepositoryInterface as Data;
use Lib\Repository\Review\ReviewRepositoryInterface as RevRepo;
use DB;

class DbTitle implements TitleRepositoryInterface
{
	/**
	 * Title model instance.
	 * 
	 * @var Title
	 */
	private $title;

	/**
	 * Writer instance.
	 * 
	 * @var Lib\Services\Db\Writer
	 */
	public $dbWriter;

    /**
     * Review model instance.
     * 
     * @var Review
     */
    private $review;

	/**
     * ImagesHandler instance.
     * 
     * @var Lib\Services\Handlers\ImagesHandler
     */
    private $images;

    /**
     * Data provider instance.
     * 
     * @var Lib\Repository\Data\DataProviderInterface
     */
    public $provider;

    /**
     * Options instace.
     * 
     * @var Lib\Services\Options\Options
     */
    private $options;

	public function __construct(Title $title, Writer $dbWriter, Imgs $images, RevRepo $review, Data $provider, Link $link, Language $language)
	{
        $this->title    = $title;
		$this->dbWriter = $dbWriter;
		$this->images   = $images;
        $this->review   = $review;
        $this->provider = $provider;
        $this->link     = $link;
        $this->language = $language;

        $this->options = App::make('Options');
	}

	/**
	 * Updates existing title from form input.
	 * 
	 * @param  array $input 
	 * @param  string $id
	 * @return void
	 */
	public function update(array $input, $id)
	{
        $title = $this->title->findOrFail($id);

		$this->updateModelAttr($title, $input);

        Event::fire('Titles.Updated', array($title, Carbon::now()));
	}

    /**
     * Updates titles reviews from metacritic.
     * 
     * @return void
     */
    public function updateReviews(Title $title)
    {
      
        $this->review->get($title)->parse()->saveFromMetacritic();
    }

	/**
     * Creates a new title.
     * 
     * @param  array $input
     * @return void
     */
    public function create(array $input)
	{
		foreach ($input as $k => $v)
		{
			if ($v === '') $v = null;
            $this->title->$k = $v;
		}

		$this->title->save();

        Event::fire('Titles.Created', array($this->title, Carbon::now()));
	}

    /**
     * Fetches and saves all available data about title.
     * 
     * @param  Title $title
     * @return Title
     */
    public function getCompleteTitle(Title $title)
    {
        $provider = $this->provider->getFullTitle($title);
  
        $this->updateReviews($title);

        Event::fire('Titles.FullyScraped', array($provider, Carbon::now()));
        
        return $this->saveAndReturn($provider, $title->id);  
    }

    /**
     * Fetches title from db using uri 245-game-of-thrones etc.
     * 
     * @param  string $title
     * @return Title
     */
    public function byUri($title)
    {
        //extract titles id in database from url
        $id = Helpers::extractId($title);

        //get title from db
        $title = $this->title->byId($id);
    
        //if title doesnt have any providers ids, is not created by user and provider is not db
        //we'll bail with 404
        if ( ! $title->imdb_id && ! $title->tmdb_id && $title->alow_update && $this->provider->name != 'db')
        {
            \App::abort(404);
        }

        return $title;
    }

    public function getTitleWithLinks($title) {
        //extract titles id in database from url
        $id = Helpers::extractId($title);

        $title = $this->title->find($id);
        $languages = $this->language->all();

        $tmp = array();
        foreach($languages as $language) {
            $tmp[] = $this->link
                                ->where('title_id', $title->id)
                                ->where('language_id', $language->id)
                                ->where('reported', '<=', 20)
                                ->get();
        }

        $title->links = $tmp;

        return $title;
    }

	/**
	 * Returns movies for displaying on movie index page.
	 * 
	 * @return Collection
	 */
	public function titleIndex($input, $type = null)
	{		
        if ($type)
        {
            $query = Title::where('type', $type);
        }
        else
        {
            $query = Title::where('1', '=', '1');
        }

        if (isset($input['genre']) && $input['genre'] != 'all')
        {
            $query = $query->where('genre', 'like', '%'. $input['genre'].'%');
        }

        if (isset($input['min_rating']) && $input['min_rating'] != 1)
        {
            $query = $query->where('mc_critic_score', '>', (int) $input['min_rating'] * 10);
        }

        if (isset($input['max_rating']) && $input['max_rating'] != 10)
        {
            $query = $query->where('mc_critic_score', '<', (int) $input['max_rating'] * 10);
        }

        if (isset($input['min_year']) && $input['min_year'] != 1880)
        {
            $query = $query->where('year', '>', (int) $input['min_year']);
        }

        if (isset($input['max_year']) && $input['max_year'] != Carbon::now()->addYears(5)->year)
        {
            $query = $query->where('year', '<', (int) $input['max_year']);
        }

        return $query->where('poster', '>', 0)->orderBy(Helpers::getOrdering(), 'desc')->paginate(18);
	}

	/**
	 * Returns series for displaying on series index page.
	 * 
	 * @return Collection
	 */
	public function seriesIndex()
	{		
		return $this->title->seriesIndex();
	}

    /**
     * Returns movies for displaying on movies index page.
     * 
     * @return Collection
     */
    public function movieIndex()
    {       
        return $this->title->movieIndex();
    }

	/**
     * Saves title to database and returns it.
     * 
     * @param  DataProviderInterface $provider
     * @param  int $id
     * @return Title
     */
    public function saveAndReturn($provider, $id)
    {
        if ($provider && $id)
        {
            $str = str_random(15);

            $this->dbWriter->setProvider($provider, $id)
                           ->setFlags( array('fully_scraped' => 1, 'temp_id' => $str) )
                           ->saveAll();

            //we'll load title by temp id incase something gets
            //messed up because of different language titles
            return $this->byTempId($str);
        }
    }

    /**
     * Fetches single title by id from db.
     * 
     * @param  int/string $id
     * @return Title
     */
    public function byId($id)
    {
    	return $this->title->byId($id);
    }

    /**
     * Fetches single title by temp id from db.
     * 
     * @param  int/string $id
     * @return Title
     */
    public function byTempId($id)
    {
        return $this->title->where('temp_id', $id)->firstOrFail();
    }

    /**
     * Checks if given title needs to be fully scraped.
     * 
     * @param  Title  $title
     * @return boolean
     */
    public function needsScraping(Title $title)
    {
        $needs = true;

        //first check for fully_scraped flag, if its true
        //we wont update
        if ($title->fully_scraped)
        {
            $needs = false;
        }

        //next check if it was 5 days  since last update
        //if so we'll update title now
        if ( ! $title->updated_at || $title->updated_at->addDays(5) <= Carbon::now() && $this->options->autoUpdateData())
        {
            $needs = true;
        }

        $date = date('Y-m-d', strtotime($title->release_date));
        if ($title->review->isEmpty() && $date < Carbon::now()->toDateString())
        {
            $needs = true;
        }

        //finally check for provider and if we're allowed to update
        //the title
        if ($this->provider->name == 'db' || ! $title->allow_update)
        {
            return false;
        }

        return $needs;
    }

    /**
     * Deletes a title from database.
     * 
     * @param  int/string $id
     * @return void
     */
    public function delete($id)
    {
    	$this->title->findOrFail($id)->delete();

        Event::fire('Titles.Deleted', array($this->title, Carbon::now()));
    }

    /**
     * Handles actor-char additions and associations to title.
     * 
     * @param array $input
     * @return  void
     */
    public function addCast($input)
    {   
        $this->attachActor($input);

        Event::fire('Titles.Modified', array($input['title-id']));
    }

    /**
     * Handles actor-char detachment from title.
     * 
     * @param array $input
     * @return  void
     */
    public function removeCast($input)
    {   
    	$title = $this->title->find($input['title']);
    	$actor = Actor::find($input['actor']);

    	$this->detach($title, $input['actor'], 'actor');

        Event::fire('Titles.Modified', array($input['title']));
    }

    /**
     * Detaches image from title.
     * 
     * @param array $input
     * @return  void
     */
    public function detachImage(array $input)
    {   
        $title = $this->title->find($input['title-id']);

        \Image::where('id', $input['image-id'])->delete();

        Event::fire('Titles.Modified', array($input['title-id']));
    }

    /**
     * Attaches image to title.
     * 
     * @param array $input
     * @return  void
     */
    public function attachImage(array $input)
    {   
        $insert = array('title_id' => $input['title-id'], 'web' => $input['image-url']);
        $this->dbWriter->compileInsert('images', $insert)->save();

        Event::fire('Titles.Modified', array($input['title-id']));
    }

    /**
     * Upload and associate image to title.
     * 
     * @param array $input
     * @return  void
     */
    public function uploadImage(array $input)
    {   
        $title = $this->title->find($input['title-id']);
        $name  = str_random(25);
        $insert = array('local' => asset('assets/images/'.$name.'.jpg'), 'title_id' => $input['title-id']);

        $this->images->saveTitleImage($input, $name);
        $this->dbWriter->compileInsert('images', $insert)->save();

        Event::fire('Titles.Modified', array($input['title-id']));
    }

    /**
     * Handles actor-char relation/names updating.
     * 
     * @param array $input
     * @return  void
     */
    public function updateCast($input)
    {     	
        $actor = Actor::whereId($input['id'])->with('title')->firstOrFail();

    	$this->updateModelAttr($actor, $input, true);

        Event::fire('Titles.Modified', array($actor->title->first()->id));
    }

    /**
     * Updates provided model with all provided values
     * using array keys as model attribute name and
     * array values as attribute value.
     * 
     * @param  Eloquent $model
     * @param  array $values
     * @return void
     */
    private function updateModelAttr($model, array $values, $pivot = false)
    {
        $updates = array_except($values, array('char_name', 'pivot_id'));
       
        foreach ($updates as $k => $v)
    	{
    		if ($v === '') $v = null;
            $model->$k = $v;
    	}

        if ($pivot)
        {
            $this->updatePivot($values);
        }
        
    	$model->save();
    }

    /**
     * Updates actors_titles pivot table with provided values.
     * 
     * @param  array $values
     * @return void
     */
    private function updatePivot(array $values)
    {
        $updates = array('id' => $values['pivot_id'], 'char_name' => $values['char_name']);

        $this->dbWriter->compileInsert('actors_titles', $updates)->save();
    }

    /**
     * Detaches many to many relations.
     * 
     * @param  Eloquent $model
     * @param  int/string $id
     * @param  string $relation
     * @return void
     */
    private function detach($model, $id, $relation)
    {
    	$model->$relation()->detach($id);
    }

    /**
     * Inserts actor into database.
     * 
     * @param  string $name
     * @return Actor
     */
    private function insertActor($name)
    {
    	$this->dbWriter->compileInsert('actors', array('name' => $name))->save();

    	return Actor::byName($name);
    }

    /**
     * Attaches actor to title from given input.
     * 
     * @param  array $input
     * @return void
     */
    private function attachActor(array $input)
    {
        //if we've got no actor id in input means we're
        //attaching a new actor to title so we need to
        //insert this actor into db first
        if ( ! isset($input['actor-id']) )
    	{
    		$actor = $this->insertActor($input['actor']);

    		$input['actor-id'] = $actor->id;
    	}

    	$this->dbWriter->compileInsert('actors_titles', array('actor_id' => $input['actor-id'], 
    								   'title_id' => $input['title-id'], 'char_name' => $input['char']))->save();
    }

    /**
     * Fetches specified amount of titles that need scraping.
     * 
     * @param  integer $amount
     * @return Collection
     */
    public function scrapable($amount = 10)
    {
        return $this->title->where('fully_scraped', 0)
                           ->where('allow_update', 1)
                           ->orderBy( Helpers::getOrdering(), 'desc')
                           ->limit( (int) $amount)
                           ->get();
    }
}