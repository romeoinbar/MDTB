<?php namespace Lib\Repository\Review;

use Title;

interface ReviewRepositoryInterface
{
	/**
     * Scrapes the reviews of provided title from metacritic.
     * 
     * @param  string $title
     * @return self
     */
    public function get(Title $title);

    /**
     * Parse the reviews from raw html.
     * 
     * @param  string $html
     * @return self
     */
    public function parse();

    /**
     * Saves reviews to database.
     *
     * @param  array $input
     * @return void
     */
    public function save(array $input);

    /**
     * Saves reviews and scores from metacritic.
     * 
     * @return void
     */
    public function saveFromMetacritic();

    /**
     * Compiles fully qualified metacritic url for scraper
     * 
     * @return string
     */
    public function url($title, $type);
}