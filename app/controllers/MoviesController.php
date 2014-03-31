<?php

class MoviesController extends \TitleController {

	/**
	 * Instantiate new movie controller instance.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Displays a grid of titles with pagination.
	 *
	 * @return View
	 */
	public function index()
	{
		$input = Input::all();

		$data = $this->title->titleIndex($input, 'movie');
  
		return View::make('Titles.Browse')->withData($data);
	}

	/**
	 * Displays the page for creating new movie.
	 *
	 * @return View
	 */
	public function create()
	{
		return View::make('Titles.Create');
	}

	/**
	 * Stores newly created movie in database.
	 *
	 * @return void
	 */
	public function store()
	{
		$input = Input::except('_token');

		if ( ! $this->validator->with($input)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors())->withInput($input);
		}

		$this->title->create($input);

		return Redirect::back()->withSuccess( trans('main.created successfully') );
	}

	/**
	 * Displays the specified movies main page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($title)
	{
		$title = $this->title->getTitleWithLinks( e($title) );
		if ($this->title->needsScraping($title))
		{
			$title = $this->title->getCompleteTitle($title);
		}

		$view = ucfirst($this->options->getTitleView());
		
		return View::make("Titles.Themes.$view.Title")->withData($title)->withId($title->id);
	}

	/**
	 * Displays page for editing general movie info.
	 *
	 * @param  string $title
	 * @return View
	 */
	public function edit($title)
	{
		$title = $this->title->byURi( e($title) );

		return View::make('Titles.Edit')->withTitle($title)->withType('movies');
	}

	/**
	 * Updates the movie from input.
	 *
	 * @param  string $id
	 * @return Redirect
	 */
	public function update($id)
	{
		$input = Input::except('_token', '_method');

		$this->title->update($input, $id);

		return Redirect::back()->withSuccess( trans('main.title update success') );
	}

	/**
	 * Deletes a movie from database.
	 *
	 * @param  string $title
	 * @return Redirect
	 */
	public function destroy($id)
	{
		$this->title->delete($id);

		return Redirect::back()->withSuccess( trans('main.movie deletion successfull') );
	}

}