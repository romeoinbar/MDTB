<?php

use Carbon\Carbon;

class TitleController extends \BaseController {

	/**
	 * Title instance.
	 * 
	 * @var Lib\Repository\Title\TitleRepositoryInterface
	 */
	protected $title;

   	/**
	 * validator instance.
	 * 
	 * @var Lib\Services\Validation\CreateTitleValidator
	 */
	protected $validator;

	/**
	 * Scraper instance.
	 * 
	 * @var Lib\Services\Scraping\Scraper
	 */
	protected $scraper;

	/**
	 * Options instance.
	 * 
	 * @var Lib\Services\Options\Options
	 */
	protected $options;

	public function __construct()
	{
		$this->afterFilter('increment', array('only' => array('show')));
		$this->beforeFilter('logged', array('except' => array('index', 'show')));
		$this->beforeFilter('titles:create', array('only' => array('create', 'store')));
		$edit = array('edit', 'update', 'editCast', 'editImages', 'uploadImage', 'attachImage', 'detachImage');
		$this->beforeFilter('titles:edit', array('only' => $edit));
		$this->beforeFilter('titles:delete', array('only' => 'destroy'));
		$this->beforeFilter('reviews:update', array('only' => 'updateReviews'));
		$this->beforeFilter('csrf', array('on' => 'post'));

		$this->title     = App::make('Lib\Repository\Title\TitleRepositoryInterface');
		$this->validator = App::make('Lib\Services\Validation\TitleValidator');
		$this->scraper   = App::make('Lib\Services\Scraping\Scraper');
		$this->options   = App::make('Options');
	}

	/**
	 * Updates titles critic reviews.
	 * 
	 * @param  mixed  $title
	 * @return Redirect
	 */
	public function updateReviews($title = null)
	{
		if ( ! $title)
		{
			$title = $this->title->byId( Input::get('id') );
		}

		$this->title->updateReviews($title);

		return Redirect::back()->withSuccess( trans('main.reviews updated') );
	}

	/**
	 * Fully scrapes specified amount of titles in db.
	 * 
	 * @return void
	 */
	public function scrapeFully()
	{
		$amount = Input::get('amount');
			
		$amount = $this->scraper->inDb($amount);

		return Redirect::back()->withSuccess( trans('dash.fully scraped', array('amount' => $amount)) );
	}

	/**
	 * Displays page for editing titles cast.
	 * 
	 * @param  int/string $id
	 * @return View
	 */
	public function editCast($id)
	{	
		$title = $this->title->byId($id);

		return View::make('Titles.EditCast')->withTitle($title);
	}

	/**
	 * Displays page for editing titles images.
	 * 
	 * @param  int/string $id
	 * @return View
	 */
	public function editImages($id)
	{	
		$title = $this->title->byId($id);

		return View::make('Titles.EditImages')->withTitle($title);
	}

	/**
	 * Attaches new actor/char pairs to title.
	 * 
	 * @return string/Redirect
	 */
	public function storeCast()
	{
		$input = Input::except('_token');

		if ( $input['actor'] && $input['char'])
		{
			$this->title->addCast($input);

			if (Request::ajax())
			{
				return 'success';
			}
			else
			{
				return Redirect::back()->withSuccess( trans('main.attached successfully') );
			}
		}
		else
		{
			if (Request::ajax())
			{
				return 'required';
			}
			else
			{
				return Redirect::back()->withFailure( trans('main.actor/char required') );
			}
		}
	}

	/**
	 * Updates now playing movies from external sources.
	 * 
	 * @return void
	 */
	public function updatePlaying()
	{
		$this->scraper->updateNowPlaying();

		Event::fire('Titles.NowPlayingUpdated', Carbon::now());

		return Redirect::back()->withSuccess( trans('dash.updated now playing successfully') );
	}
	
	/**
	 * Detaches actor/char pair from title.
	 * 
	 * @return Redirect
	 */
	public function destroyCast()
	{
		$input = Input::except('_token');
	
		if ($input['actor'] && $input['title'])
		{
			$this->title->removeCast($input);

			return Redirect::back()->withSuccess( trans('main.detached successfully') );
		}
	}

	/**
	 * Detaches image from title.
	 * 
	 * @return Redirect
	 */
	public function detachImage()
	{
		$input = Input::except('_token');
	
		if (isset($input['title-id']) && isset($input['image-id']))
		{
			$this->title->detachImage($input);

			return Redirect::back()->withSuccess( trans('main.detached image successfully') );
		}

		return Redirect::back()->withFailure( trans('main.something went wrong') );
	}

	/**
	 * Attaches image to title.
	 * 
	 * @return Redirect
	 */
	public function attachImage()
	{
		$input = Input::except('_token');
		
		if (isset($input['title-id']) && $input['image-url'] != '')
		{
			$this->title->attachImage($input);

			return Redirect::back()->withSuccess( trans('main.detached image successfully') );
		}

		return Redirect::back()->withFailure( trans('main.enter title url please') );
	}

	/**
	 * Uploads and associates image to title.
	 * 
	 * @param  string $username
	 * @return void
	 */
	public function uploadImage()
	{
		$input = array('image' => Input::file('image'), 'title-id' => Input::get('title-id'));

		if ( ! $this->validator->setRules('image')->with($input)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors());
		}

		$this->title->uploadImage($input);

		return Redirect::back()->withSuccess( trans('main.uploaded image success') );
	}

	/**
	 * Edits actor/char pair attached to specific title
	 * information (char name, image, actor name).
	 * 
	 * @return Redirect
	 */
	public function editCastInfo()
	{
		$input = Input::except('_token');

		if ( $input['name'] && $input['char_name'])
		{
			$this->title->updateCast($input);

			if (Request::ajax())
			{
				return 'success';
			}
			else
			{
				return Redirect::back()->withSuccess( trans('main.updated relation successfully') );
			}
		}
		else
		{
			if (Request::ajax())
			{
				return 'required';
			}
			else
			{
				return Redirect::back()->withFailure( trans('main.actor/char required') );
			}
		}

	}


}