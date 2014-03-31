<?php namespace Lib\Repository\Season;

use Title;

interface SeasonRepositoryInterface
{
    /**
     * Prepares single season for displaying.
     * 
     * @param  Title  $title
     * @param  string $num
     * @return Title
     */
	public function prepareSingle(Title $title, $num);

    /**
     * Handles single season loading if provider is not tmdb.
     * 
     * @param  DataProviderInterface $provider
     * @param  Title $title
     * @param  int/string $num
     * @return Title
     */
    public function handleSingleLoading($title, $num);

    /**
     * Finds season by title id and season number.
     * 
     * @param  string $title
     * @param  int/string $num
     * @return Season/404
     */
    public function findById($id, $num);

    /**
     * Handles new season creation from input.
     * 
     * @param  array $input
     * @return void
     */
    public function create(array $input);

    /**
     * Handles season deletion.
     * 
     * @param  int/string $series series id
     * @param  int/string $season season id
     * @return void
     */
    public function delete($series, $season);

    /**
     * Fetches series with all seasons and episodes.
     * 
     * @param  string $title
     * @return Title
     */
    public function withSeasonsEpisodes($title);
}