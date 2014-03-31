<?php

use Lib\Repository\Lists\ListsRepositoryInterface as ListInterface;

class ListsController extends BaseController
{
	/**
	 * List repostiry instance.
	 * 
	 * @var Lib\Repository\Lists\ListRepositoryInterface
	 */
	private $list;

	public function __construct(ListInterface $list)
	{
		$this->list = $list;
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('logged');
	}

	/**
	 * Add title to specified list of user.
	 * 
	 * @return Redirect/string
	 */
	public function postAdd()
	{
		$input = Input::except('_token');

		if ( ! isset($input['user']) || ! isset($input['title']))
		{
			if (Request::ajax())
			{
				return trans('main.no user/title id');
			}

			return Redirect::back()->withFailure( trans('main.no user/title id') );
		}

		$this->list->add($input);

		if (Request::ajax())
		{
			return trans('main.added to list');
		}

		return Redirect::back()->withSuccess( trans('main.added to list') );
	}

	public function postRemove()
	{
		$input = Input::except('_token');

		if ( ! isset($input['user']) || ! isset($input['title']))
		{
			if (Request::ajax())
			{
				return trans('main.no user/title id');
			}

			return Redirect::back()->withFailure( trans('main.no user/title id') );
		}

		$this->list->remove($input);
		
		if (Request::ajax())
		{
			return trans('main.removed from list');
		}

		return Redirect::back()->withSuccess( trans('main.removed from list') );

	}

}