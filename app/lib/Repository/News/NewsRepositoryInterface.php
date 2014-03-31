<?php namespace Lib\Repository\News;

use News;

interface NewsRepositoryInterface
{
	/**
	 * Fetches the data needed to make news
	 * index page.
	 * 
	 * @return Collection
	 */
	public function index();

	/**
	 * Stores new news item to database.
	 * 
	 * @param  array $input
	 * @return void
	 */
	public function store(array $input);

	/**
	 * Deletes specified news item.
	 * 
	 * @param  int/string $id
	 * @return void
	 */
	public function delete($id);

	/**
	 * Fetches news item from db by id.
	 * 
	 * @param  int/string $id
	 * @return News model
	 */
	public function byId($id);

	/**
	 * Handles news items updating.
	 * 
	 * @param  News $news
	 * @param  array $input
	 * @return void
	 */
	public function update(News $news, array $input);

}