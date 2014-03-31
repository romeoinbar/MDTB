<?php

class SeriesController extends \TitleController {

	/**
	 * Instantiate new series controller instance.
	 */
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$input = Input::all();

		$data = $this->title->titleIndex($input, 'series');
       
		return View::make('Titles.Browse')->withData($data);
	}

	/**
	 * Displays the page for creating new series.
	 *
	 * @return View.
	 */
	public function create()
	{
		return View::make('Titles.Create');
	}

	/**
	 * Stores newly created series in database.
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
	 * Displays the series main page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($title)
	{
		$title = $this->title->byUri( e($title) );

		if ($this->title->needsScraping($title))
		{
			$title = $this->title->getCompleteTitle($title);

		}

		$view = ucfirst($this->options->getTitleView());

		return View::make("Titles.Themes.$view.Title")->withData($title)->withId($title->id);;
	}

	/**
	 * Displays page for editing general series info.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($title)
	{
		$title = $this->title->byUri( e($title) );

		return View::make('Titles.Edit')->withTitle($title)->withType('series');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::except('_token', '_method');

		if ( ! $this->validator->with($input)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors())->withInput($input);
		}

		$this->title->update($input, $id);

		return Redirect::back()->withSuccess( trans('main.title update success') );
	}

	/**
	 * Deletes a series from database.
	 *
	 * @param  string $title
	 * @return Redirect
	 */
	public function destroy($title)
	{
		$this->title->delete($id);

		return Redirect::back()->withSuccess( trans('main.movie deletion successfull') );
	}

}