<?php

use Carbon\Carbon;
use Lib\Services\Scraping\Scraper;
use Lib\Services\Validation\NewsValidator;
use Lib\Repository\News\NewsRepositoryInterface as NewsRepo;

class NewsController extends \BaseController {

	/**
	 * News model instance.
	 * 
	 * @var News
	 */
	private $news;

	/**
	 * validator instance.
	 * 
	 * @var Lib\Services\Validation\NewsCreateValidator
	 */
	private $validator;

	/**
	 * News scraper isntance.
	 * 
	 * @var Lib\Services\Scraping\NewScraper;
	 */
	private $scraper;

	public function __construct(NewsRepo $news, NewsValidator $validator, Scraper $scraper)
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('logged', array('except' => array('index', 'show')));
		$this->beforeFilter('news:create', array('only' => array('create', 'store')));
		$this->beforeFilter('news:edit', array('only' => array('edit', 'update')));
		$this->beforeFilter('news:delete', array('only' => 'destroy'));
		$this->beforeFilter('news:update', array('only' => 'updateFromExternal'));

		$this->news = $news;
		$this->scraper = $scraper;
		$this->validator = $validator;
	}

	/**
	 * Display list of paginated news.
	 *
	 * @return View
	 */
	public function index()
	{
		$news = $this->news->index();

		return View::make('News.Master')->withNews($news);
	}

	/**
	 * Display form for creating new news items.
	 *
	 * @return View
	 */
	public function create()
	{
		return View::make('News.Create');
	}

	/**
	 * Store a newly created news item.
	 *
	 * @return Redirect
	 */
	public function store()
	{
		$input = Input::except('_token');

		if ( ! $this->validator->with($input)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors())->withInput($input);
		}

		//escape double qoutes
		$input['title'] = htmlspecialchars($input['title']);
		
		$this->news->store($input);

		return Redirect::back()->withSuccess( trans('main.news create success') );
	}

	/**
	 * Display single news items.
	 *
	 * @param  int  $id
	 * @return View
	 */
	public function show($id)
	{
		$news = $this->news->byId($id);

		if ($news->full_url && ! $news->fully_scraped)
		{
			$news = $this->news->getFullNewsItem($news);
		}

		return View::make('News.Single')->With( compact('news') );
	}

	/**
	 * Displays form for editing news item.
	 *
	 * @param  int  $id
	 * @return View
	 */
	public function edit($id)
	{
		$news = $this->news->byId($id);

		return View::make('News.Edit')->withNews($news);
	}

	/**
	 * Updates the news item.
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function update($id)
	{
		$input = Input::except('_token', '_method');

		$news = $this->news->byId($id);

		if ($news->title === $input['title'])
		{
			//dont check for title uniqueness when updating if
			//title was not updated.
			$this->validator->rules['title'] = 'required|min:2|max:255';
		}
		
		if ( ! $this->validator->with($input)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors())->withInput($input);
		}

		//escape double qoutes
		$input['title'] = htmlspecialchars($input['title']);

		$this->news->update($news, $input);	

		return Redirect::back()->withSuccess( trans('main.news update success') );
	}

	/**
	 * Delete specified news item.
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function destroy($id)
	{
		$this->news->delete($id);		

		return Redirect::back()->withSuccess( trans('main.news delete success') );
	}

	/**
	 * Updates news from external sources.
	 * 
	 * @return void
	 */
	public function updateFromExternal()
	{
		$this->scraper->updateNews();

		Event::fire('News.Updated', Carbon::now());

		return Redirect::back()->withSuccess( trans('dash.updated news successfully') );
	}

}