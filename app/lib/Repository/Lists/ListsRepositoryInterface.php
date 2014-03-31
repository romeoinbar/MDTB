<?php namespace Lib\Repository\Lists;

interface ListsRepositoryInterface
{
	/**
	 * Adds given title to given list of user.
	 *
	 * @return  String/Redirect
	 */
	public function add(array $input);

	/**
	 * Removes given title from given list of user.
	 *
	 * @return  String/Redirect
	 */
	public function remove(array $input);
}