<?php

use Lib\Services\Db\Writer;
use Lib\Services\Scraping\Scraper;
use Lib\Repository\Data\ImdbData as Data;
use Lib\Services\Validation\UserValidator;


class InstallController extends BaseController
{
	/**
	 * Validator instance.
	 * 
	 * @var Lib\Services\Validation\UserValidator
	 */
	private $validator;

	/**
	 * Scraper instance.
	 * 
	 * @var Lib\Services\Scraping\Scraper
	 */
	private $scraper;

	/**
	 * Imdb data instance.
	 * 
	 * @var Lib\Repository\Data\ImdbData
	 */
	private $imdb;

	/**
	 * Writer instance.
	 * 
	 * @var Lib\Services\Db\Writer
	 */
	private $writer;


	public function __construct(UserValidator $validator, Scraper $scraper, Data $imdb, Writer $writer)
	{
		$this->imdb = $imdb;
		$this->writer = $writer;
		$this->scraper = $scraper;
		$this->validator = $validator;	
	}

	/**
	 * Shows index install view.
	 * 
	 * @return View
	 */
	public function install()
	{
		return View::make('Install.CreateSchema');	
	}

	/**
	 * Creates database schema.
	 * 
	 * @return Redirect
	 */
	public function createSchema()
	{
		ini_set('max_execution_time', 0);

		//create database schema
		Artisan::call('migrate:install');
		Artisan::call('migrate');

		return Redirect::to('install/create-admin');
	}

	/**
	 * Show super user creation form.
	 * 
	 * @return View
	 */
	public function createAdmin()
	{
		return View::make('Install.CreateAdmin');
	}

	/**
	 * Creates super user account.
	 * 
	 * @return Redirect
	 */
	public function storeAdmin()
	{
		$input = Input::except('_token');

		if ( ! $this->validator->with($input)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors())->withInput($input);
		}

		//activate the admin and add superuser permissions
		$input['activated'] = 1;
		$input['permissions'] = array('superuser' => 1);

		Sentry::createUser( array_except($input, 'password_confirmation') );

		return Redirect::to('install/create-data');
	}

	public function createData()
	{
		return View::make('Install.CreateData');
	}

	/**
	 * Fetches data that user requested.
	 * 
	 * @return Redirect
	 */
	public function storeData()
	{
		//fetch news
		if ( Input::get('news') )
		{
			$this->scraper->updateNews();
		}
		
		//fetch featured trailer
		if ( Input::get('featured') )
		{
			$this->scraper->featured();
		}

		//fetch now in theaters movies
		if ( Input::get('theaters') )
		{
			$titles = $this->imdb->getNowPlaying();
			$this->writer->insertFromImdbSearch($titles);
		}

		//when everything is done add a flag to
		//options table so the install routes
		//cant be accessed again
		DB::table('options')->insert(array(
			array('name' => 'installed', 'value' => 1),
			array('name' => 'data_provider', 'value' => 'imdb'),
			array('name' => 'search_provider', 'value' => 'imdb'),
			array('name' => 'home_bg', 'value' => 'romanoff.jpg'),
			array('name' => 'register_bg', 'value' => 'elysium.jpg'),
			array('name' => 'login_bg', 'value' => 'gravity.jpg'),
			array('name' => 'dash_bg', 'value' => 'firey.jpg'),
			array('name' => '404_bg', 'value' => 'hangover.jpg'),
			array('name' => 'title_view', 'value' => 'Tabs'),
			array('name' => 'updated', 'value' => 1),
		));

		return Redirect::to('/')->withSuccess( trans('main.install success') );
	}
}