<?php namespace Lib\Repository\Title;

interface TitleRepositoryInterface
{
	/**
	 * Updates title information.
	 * 
	 * @param  array $input 
	 * @param  string $id
	 * @return void
	 */
	public function update(array $input, $id);

    /**
     * Updates titles reviews from metacritic.
     * 
     * @return void
     */
    public function updateReviews(\Title $title);

	/**
     * Creates a new title.
     * 
     * @param  array $input
     * @return void
     */
    public function create(array $input);

    /**
     * Fetches and saves all available data about
     * title from data providers.
     * 
     * @param  Title $title
     * @return Title
     */
    public function getCompleteTitle(\Title $title);

    /**
     * Fetches title from db using uri 245-game-of-thrones etc.
     * 
     * @param  string $title
     * @return Title
     */
    public function byUri($title);

	/**
	 * Returns movies for displaying on movie index page.
	 * 
	 * @return Collection
	 */
	public function movieIndex();

	/**
	 * Returns series for displaying on series index page.
	 * 
	 * @return Collection
	 */
	public function seriesIndex();

	/**
     * Saves title to database with fully_scraped
     * flag set to 1 and returns it.
     * 
     * @param  DataProviderInterface $provider
     * @param  int $id
     * @return Title
     */
    public function saveAndReturn($provider, $id);

    /**
     * Fetches single title by id from db.
     * 
     * @param  int/string $id
     * @return Title
     */
    public function byId($id);

    /**
     * Fetches single title by temp id from db.
     * 
     * @param  int/string $id
     * @return Title
     */
    public function byTempId($id);

    /**
     * Checks if given title needs to be fully scraped.
     * 
     * @param  Title  $title
     * @return boolean
     */
    public function needsScraping(\Title $title);

    /**
     * Deletes a title from database.
     * 
     * @param  int/string $id
     * @return void
     */
    public function delete($id);

    /**
     * Handles actor-char attachment to title.
     * 
     * @param array $input
     * @return  void
     */
    public function addCast($input);

    /**
     * Handles actor-char detachment from title.
     * 
     * @param array $input
     * @return  void
     */
    public function removeCast($input);

    /**
     * Handles actor-char relation/names updating.
     * 
     * @param array $input
     * @return  void
     */
    public function updateCast($input);

    /**
     * Fetches specified amount of titles that need scraping.
     * 
     * @param  integer $amount
     * @return Collection
     */
    public function scrapable($amount = 10);
}