<?php namespace Lib\Repository\Actor;

interface ActorRepositoryInterface
{
	/**
	 * Fetches all available actor info.
	 * 
	 * Checks db if actor is fully scraped, returns if yes
	 * else gets all info about actor from provider, saves
	 * to db and then returns.
	 *
	 * @param  string id
	 * @return Actor
	 */
	public function fetchFull($id);

	/**
	 * Updates actor with provided input.
	 * 
	 * @param  array  $input
	 * @return void
	 */
	public function update(array $input);

	/**
	 * Removes title from actors filmography.
	 * 
	 * @param  array $input
	 * @return void
	 */
	public function unlink(array $input);

	/**
	 * Makes actor known for title in his filmography.
	 *
	 * @param array $input
	 * @return Redirect
	 */
	public function knownFor(array $input);

	/**
	 * Deletes actor from database.
	 * 
	 * @param  string $id
	 * @return void
	 */
	public function delete($id);

	/**
	 * Creates new actor in database.
	 * 
	 * @param  array  $input
	 * @return void
	 */
	public function create(array $input);

	/**
	 * Fetchs all actors from database and paginates them.
	 * 
	 * @return Paginator
	 */
	public function allPagi();
}