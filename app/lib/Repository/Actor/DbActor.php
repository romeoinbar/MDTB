<?php namespace Lib\Repository\Actor;

use Lib\Services\Db\Writer;
use Lib\Services\Options\Options;
use Actor, Helpers, Title, Event, App;
use Lib\Repository\ActorData\ActorDataRepositoryInterface as ActorData;

class DbActor implements ActorRepositoryInterface
{
	/**
	 * Actor model instance.
	 * 
	 * @var Actor
	 */
	private $actor;

	/**
	 * Data repository instance.
	 * 
	 * @var Lib\Repository\Data\DataProviderInterface
	 */
	private $provider;

	/**
	 * Writer instance.
	 * 
	 * @var Lib\Services\Db\Writer
	 */
	private $dbWriter;

	/**
	 * Temp actor id store so we can
	 * associate actor with titles easily.
	 * 
	 * @var string/int
	 */
	private $actorId;

	/**
	 * Title model instance
	 * 
	 * @var Title
	 */
	private $title;

	/**
	 * Options instance.
	 * 
	 * @var Lib\Services\Options\Options
	 */
	private $options;

	public function __construct(Actor $actor, ActorData $provider, Writer $dbWriter, Title $title)
	{
		$this->actor = $actor;
		$this->title = $title;
		$this->dbWriter = $dbWriter;
		$this->provider = $provider;

		$this->options = App::make('Options');
	}

	/**
	 * Updates actor with provided input.
	 * 
	 * @param  array  $input
	 * @return void
	 */
	public function update(array $input)
	{
		$actor = $this->actor->findOrFail( $input['id'] );

		$this->updateModelAttr($actor, $input);

		Event::fire('Actor.Updated', array($actor->id));
	}

	/**
	 * Deletes actor from database.
	 * 
	 * @param  string $id
	 * @return void
	 */
	public function delete($id)
	{
		$this->actor->destroy($id);

		Event::fire('Actor.Deleted', array($id));
	}

	/**
	 * Creates new actor in database.
	 * 
	 * @param  array  $input
	 * @return void
	 */
	public function create(array $input)
	{
		foreach ($input as $k => $v)
		{
			$this->actor->$k = $v;
		}

		$this->actor->save();

		Event::fire('Actor.Created', array($input['name']));
	}

	/**
	 * Removes title from actors filmography.
	 * 
	 * @param  array $input
	 * @return void
	 */
	public function unlink(array $input)
	{
		$actor = $this->actor->findOrFail( $input['actor'] );

		$actor->title()->detach( $input['title'] );

		Event::fire('Actor.Updated', array($input['actor']));
	}

	/**
	 * Make actor known for title in his filmography.
	 *
	 * @param array $input
	 * @return Redirect
	 */
	public function knownFor(array $input)
	{
		$this->dbWriter->compileInsert('actors_titles', $input)->save();

		Event::fire('Actor.Updated', array($input['actor_id']));
	}

	/**
	 * Updates model with provided values.
	 * 
	 * @param  mixed $model
	 * @param  array $values
	 * @return void
	 */
	private function updateModelAttr($model, array $values)
	{
		foreach ($values as $k => $v)
		{
			if ($v || $v == '0') $model->$k = $v;
		}

		$model->save();
	}

	/**
	 * Fetchs all actors from database and paginates them.
	 * 
	 * @return Paginator
	 */
	public function allPagi()
	{
		return $this->actor->orderBy('views', 'desc')->paginate(24);
	}

	/**
	 * Fetches all available actor info.
	 * 
	 * first checks db if actor is fully scraped then returns,
	 * else gets all info about actor from provider saves
	 * to db and the returns.
	 *
	 * @param  string id
	 * @return Actor
	 */
	public function fetchFull($id)
	{
		$id = Helpers::extractId($id);

		$actor = $this->actor->with('title')->findOrFail($id);

		return $this->prepareActor($actor);	
	}

	/**
	 * Prepares actor for displaying.
	 * 
	 * @param  Actor  $actor
	 * @return Actor
	 */
	private function prepareActor(Actor $actor)
	{	
		if ($actor->fully_scraped || $this->options->getDataProvider() == 'db' || ! $actor->allow_update)
		{
			return $actor;
		}
		
		//get all avalaible actor data from provider and insert into db.
		$actor = $this->provider->getActor($actor);
		$this->saveFromExternal($actor);
	
		$fullActor = $this->actor->with('title')->findOrFail($this->actorId);

		return $fullActor;
	}

	/**
	 * Saves info about actor from external
	 * sources (imdb, tmdb etc).
	 * 
	 * @return void
	 */
	private function saveFromExternal($actor)
	{	
   		$this->saveGenInfo($actor);
   		$this->saveFilmography($actor);
   		$this->saveKnownFor($actor);
	}

	 /**
    * Saves general information about actor (name, bio etc).
    * 
    * @param  mixed actor 
    * @return void
    */
   private function saveGenInfo($actor)
   {
	   	$gen = $actor->getGenInfo();

	   	//set flags and temp id
	   	$temp = str_random(10);
	   	$gen['temp_id'] = $temp;
	    $gen['fully_scraped'] = 1;

	   	//insert and get back id in database
	   	$this->dbWriter->compileInsert('actors', $gen)->save();
	   	$this->actorId = $this->actor->where('temp_id', $temp)->first()->id;
   }

    /**
    * Saves titles actor is known for and associates them.
    * 
    * @param  mixed $actor
    * @return void
    */
   private function saveKnownFor($actor)
   {
	   	$known = $actor->getKnownFor();

	   	if ($known)
	   	{
	   		$temp = str_random(10);
			$knownFor = $this->addTempId($known, $temp);

	   		$this->dbWriter->compileBatchInsert('titles', $knownFor)->save();

	   		$this->associate($temp, 1);
	   	}   	
   }

    /**
    * Saves actors filmography.
    * 
    * @param  mixed $actor
    * @return void
    */
   private function saveFilmography($actor)
   {
		$filmo = $actor->getFilmography();

		$temp = str_random(10);
	   	$filmography = $this->addTempId($filmo, $temp);

	   	$this->dbWriter->compileBatchInsert('titles', $filmography)->save();

	   	$this->associate($temp);
   }

   /**
    * Associates actors with titles.
    * 
    * @param  string $temp tempId of titles to associate.
    * @return void
    */
   private function associate($temp, $known = 0)
   {
	   	$titles = $this->title->Where('temp_id', '=', $temp)->lists('id');
	   	
	   	foreach ($titles as $k => $v)
	   	{
	   		$insert[] = array('actor_id' => $this->actorId, 'title_id' => $v, 'known_for' => $known);
	   	}

	   	$this->dbWriter->compileBatchInsert('actors_titles', $insert)->save();
   }

   /**
    * Adds temp id into each array item.
    * 
    * @param array $array 
    * @param string $temp
    */
   private function addTempId(array $array, $temp)
   {
	   	foreach ($array as $k => $v)
	   	{
	   		$array[$k]['temp_id'] = $temp;
	   	}

	   	return $array;
	}

}