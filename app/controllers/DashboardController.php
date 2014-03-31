<?php

use Lib\Services\Scraping\Scraper;
use Lib\Repository\Dashboard\DashboardRepositoryInterface as Dash;
use Lib\Services\Validation\DashboardValidator as Validator;

class DashboardController extends BaseController
{
	/**
	 * Scraper instance.
	 * 
	 * @var Lib\Services\Scraping\Scraper
	 */
	private $scraper;

	/**
	 * Validator instance.
	 * 
	 * @var Lib\Services\Validation\DashboardValidator
	 */
	private $validator;

	/**
	 * Dashboard repository instance.
	 * 
	 * @var Lib\Repository\Dashboard\DashboardRepositoryInterface
	 */
	private $dashboard;

	/**
	 * Options instance.
	 * 
	 * @var Lib\Services\Options\Options
	 */
	private $options;

	public function __construct(Dash $dashboard, Validator $validator, Scraper $scraper)
	{
		$this->beforeFilter('logged');
		$this->beforeFilter('is.admin');
		$this->beforeFilter('csrf', array('on' => 'post'));
		
		$this->scraper   = $scraper;		
		$this->dashboard = $dashboard;
		$this->validator = $validator;
		$this->options   = App::make('Options');
	}

	/**
	 * Updates movies that are now playing in theaters.
	 * 
	 * @return Redirect
	 */
	public function postNowPlaying()
	{
		$this->scraper->updateNowPlaying();

		return Redirect::back()->withSuccess( trans('dash.updated now playing successfully') );
	}

	/**
	 * Updates featured titles.
	 * 
	 * @return Redirect
	 */
	public function postFeaturedTrailers()
	{
		$this->scraper->featured();

		return Redirect::back()->withSuccess( trans('dash.updated featured successfully') );
	}

	/**
	 * Handle imdb advanced search scraping.
	 * 
	 * @return Redirect
	 */
	public function postImdbAdvanced()
	{
		$input = Input::except('_token');

		if ( ! $this->validator->setRules('imdbScrape')->with($input)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors())->withInput($input);
		}

		if ( ! $amount = $this->scraper->imdbAdvanced($input) )
		{
			return Redirect::back()->withFailure( trans('dash.failed to scrape') );
		}

		return Redirect::back()->withSuccess( trans('dash.scraped successfully', array('number' => $amount - 1)) );	
	}

	/**
	 * Handle tmdb discover scraping.
	 * 
	 * @return Redirect
	 */
	public function postTmdbDiscover()
	{
		$input = Input::except('_token');

		if ( ! $amount = $this->scraper->tmdbDiscover($input) )
		{
			return Redirect::back()->withFailure( trans('dash.failed to scrape') );
		}

		return Redirect::back()->withSuccess( trans('dash.scraped successfully', array('number' => $amount)) );	
	}

	/**
	 * Cleans all data in the app including
	 * database, cache and downloaded files.
	 * 
	 * @return Redirect
	 */
	public function postTruncate()
	{
		$this->dashboard->truncate();

		return Redirect::back()->withSuccess( trans('main.truncate success') );
	}

	/**
	 * Stores updated options in database.
	 * 
	 * @return Redirect
	 */
	public function postOptions()
	{
		$options = Input::except('_token', '_method');

		if ( ! $this->validator->setRules('options')->with($options)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors())->withInput($options);
		}

		$this->dashboard->updateOptions($options);

		return Redirect::back()->withSuccess( trans('dash.options update success') );
	}
}