<?php

use Lib\Services\Options\Options;
use Lib\Repository\Actor\DbActor;
use Lib\Services\Validation\ActorValidator;

class ActorController extends \BaseController {

	/**
	 * Actor repository instance.
	 * 
	 * @var Lib\Repository\Actor\DbActor
	 */
	private $actor;

	/**
	 * Validator instance.
	 * 
	 * @var Lib\Services\Validation\ActorValidator
	 */
	private $validator;

	/**
	 * Options instance.
	 * 
	 * @var Lib\Services\Options\Options;
	 */
	private $options;

	public function __construct(DbActor $actor, ActorValidator $validator, Options $options)
	{
		$this->afterFilter('increment', array('only' => array('show')));
		$this->beforeFilter('logged', array('except' => array('index', 'show')));
		$this->beforeFilter('people:create', array('only' => array('create', 'store')));
		$this->beforeFilter('people:edit', array('only' => array('edit', 'update', 'editFilmo')));
		$this->beforeFilter('people:delete', array('only' => 'destroy'));
		$this->beforeFilter('csrf', array('on' => 'post'));

		$this->actor = $actor;
		$this->options = $options;
		$this->validator = $validator;
	}

	/**
	 * Displays a grid of actors.
	 *
	 * @return View
	 */
	public function index()
	{
		$actors = $this->actor->allPagi();

		return View::make('Actor.All')->withActors($actors);
	}

	/**
	 * Displays a page for creating new actor.
	 *
	 * @return View
	 */
	public function create()
	{
		return View::make('Actor.Create');
	}

	/**
	 * Stores new actor in database.
	 *
	 * @return Redirect
	 */
	public function store()
	{
		$input = Input::except('_method', '_token');

		if ( ! $this->validator->with($input)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors())->withInput($input);
		}

		$this->actor->create($input);

		return Redirect::back()->withSuccess( trans('main.created actor successfully') );
	}

	/**
	 * Show the main actor page.
	 *
	 * @param  string $id
	 * @return View
	 */
	public function show($id)
	{
		$provider = $this->options->getDataProvider();

		$actor = $this->actor->fetchFull($id);

		return View::make('Actor.Actor')->withActor($actor)->withProvider($provider);
	}

	/**
	 * Displays the actor edit page.
	 *
	 * @param  mixed $id
	 * @return View
	 */
	public function edit($id)
	{
		$actor = $this->actor->fetchFull($id);

		return View::make('Actor.Edit')->withActor($actor);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::except('_method', '_token');

		if ( ! $this->validator->with($input)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors())->withInput($input);
		}

		$this->actor->update($input);

		return Redirect::back()->withSuccess( trans('main.updated successfully', array('item' => $input['name'])) );
	}

	/**
	 * Displays form for editing actors filmography.
	 *
	 * @param  mixed $id
	 * @return View
	 */
	public function editFilmo($id)
	{
		$actor = $this->actor->fetchFull($id);

		return View::make('Actor.EditFilmo')->withActor($actor);
	}

	/**
	 * Removes specified title from actors filmography.
	 * 
	 * @return Redirect
	 */
	public function unlinkTitle()
	{
		$input = Input::except('_token');

		$this->actor->unlink($input);

		return Redirect::back()->withSuccess( trans('main.unlinked successfully') );
	}


	/**
	 * Change titles known for status in actors filmo.
	 * 
	 * @return Redirect
	 */
	public function knownFor()
	{
		$input = Input::except('_token');

		$this->actor->knownFor($input);

		return Redirect::back()->withSuccess( trans('main.changed titles status') );
	}

	/**
	 * Deletes actor from database.
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function destroy($id)
	{
		$this->actor->delete($id);

		return Redirect::back()->withSuccess( trans('main.delete success') );
	}

}