<?php namespace Lib\Services\Scraping;

use Title, App, Event;
use Lib\Services\Db\Writer;
use Lib\Repository\Data\ImdbData;
use Lib\Repository\Title\TitleRepositoryInterface as TitleRepo;
use Lib\Services\Scraping\Scraper;
use Lib\Repository\Data\TmdbData as Tmdb;
use Lib\Repository\Review\DbReview as Rev;
use Lib\Services\Search\ImdbSearch as Imdb;

class BatchScraper extends Curl
{
	
	/**
	 * DbTitle instance.
	 * 
	 * @var Lib\Repository\Title\TitleRepositoryInterface
	 */
	private $title;

	/**
	 * DbReview instance.
	 * 
	 * @var Lib\Repository\Review\DbReview
	 */
	private $review;

	/**
	 * Writer instance.
	 * 
	 * @var Lib\Services\Db\Writer
	 */
	private $dbWriter;

	/**
	 * Main Scraper instance.
	 * 
	 * @var Lib\Services\Search\ImdbSearch
	 */
	private $imdbSearch;

	/**
	 * TmdbData instance.
	 * 
	 * @var Lib\Repository\Data\TmdbData
	 */
	private $tmdb;

	public function __construct(TitleRepo $title, Writer $dbWriter, Rev $review, Imdb $imdbSearch, Tmdb $tmdb)
	{
		$this->tmdb 	  = $tmdb;
		$this->title      = $title;
		$this->review     = $review;
		$this->dbWriter   = $dbWriter;
		$this->imdbSearch = $imdbSearch;
	}

	/**
	 * Fetches and saves all available information about titles,
	 * that arent fully scraped in database.
	 * 
	 * @param  int/string $amount
	 * @return int/string
	 */
	public function inDb($amount = 10)
	{
		ini_set('max_execution_time', 0);

		$titles = $this->title->scrapable($amount);

		$count = 0;

		foreach ($titles as $k => $v)
		{
			$title = App::make('Lib\Repository\Title\TitleRepositoryInterface');

			$title->getCompleteTitle($v);
			$count++;
		}

		return $count;
	}

	/**
	 * Fetches and saves featured movies.
	 * 
	 * @return void
	 */
	public function featured()
	{
		Event::fire('Titles.FeaturedUpdating');

		ini_set('max_execution_time', 0);

		$ids = $this->fetchIdsFromTrailerAddict();

		$html = $this->imdbFromIds($ids);

		$this->saveFeatured($html);

		Event::fire('Titles.FeaturedUpdated');
	}

	/**
	 * Scrapes titles from imdb only from their ids array.
	 *
	 * @param array $ids
	 * @return array 
	 */
	public function imdbFromIds($ids)
	{
		$base = 'http://www.imdb.com/title/';

		//construct main and image imdb urls
		foreach ($ids as $id)
		{
			$main = $base . $id . '/';
			$images = $main . 'mediaindex?refine=still_frame';

			$html[] = $this->multiCurl(array($main, $images));
		}

		return $html;
	}

	/**
	 * Saves featured movies to db.
	 * 
	 * @param  string $html
	 * @return void
	 */
	private function saveFeatured($html)
	{
		foreach($html as $h)
		{			
			$flags = array('featured' => 1, 'fully_scraped' => 1, 'temp_id' => str_random(15));

			$writer = new Writer( new ImdbData($h), $flags);
			$writer->saveAll();
		}
	}

	/**
	 * Fetches featured movies imdb ids from trailer addict.
	 * 
	 * @return array
	 */
	private function fetchIdsFromTrailerAddict()
	{
		$ids = $this->curl("http://api.traileraddict.com/?featured=yes&count=8");
		$ids = simplexml_load_string($ids);

		foreach ($ids as $id)
		{
			$prefixed[] = 'tt' . $id->imdb;
		}

		return $prefixed;
	}

	/**
	 * Fetches titles using tmdb api discover query.
	 * 
	 * @param  array $input
	 * @return int how much titles scraped
	 */
	public function tmdbDiscover(array $input)
	{
		return $this->tmdb->discover($input);
	}

	/**
	 * Fetches and saves now playing movies.
	 * 
	 * @return void
	 */
	public function nowPlaying()
	{
		Event::fire('Titles.NowPlayingUpdating');

		$titles = $this->title->provider->getNowPlaying();

		//if provider is imdb we'll need to run titles
		//trough imdb search insert because we need to save
		//images to filesystem first
		if ($this->title->provider->name == 'imdb')
		{
			$this->dbWriter->insertFromImdbSearch($titles);
		}
		else
		{
			$this->dbWriter->compileBatchInsert('titles', $titles)->save();
		}

		Event::fire('Titles.NowPlayingUpdated', array($titles));
	}

	/**
	 * Scrapes titles from imdb advanced search
	 * 
	 * @param  array $input
	 * @return void
	 */
	public function imdbAdvanced(array $input)
	{
		ini_set('max_execution_time', 0);

		$url = $this->compileImdbAdvancedUrl($input);

		$amount = $input['howMuch'];
		
		$currentPage = 1;

		while ($currentPage <= $amount)
		{
			$html = $this->curl($url);

			//increment current page by 100 as thats how many
			//titles page containts
			$currentPage = $currentPage + 100;

			//change url so it starts at 100 more then previous scrape
			$url = preg_replace('/&start=[0-9]+/', "&start=$currentPage", $url);

			$data = $this->imdbSearch->compileSearchResults($html);

			if ( ! $data) return false;
			
			$this->dbWriter->insertFromImdbSearch($data);
		}

		Event::Fire('Titles.Updated');

		return $currentPage;
	}

	/**
	 * Compiles imdb advanced search url from user input.
	 * 
	 * @param  array $input
	 * @return string
	 */
	private function compileImdbAdvancedUrl(array $input)
	{	
		$url = 'http://www.imdb.com/search/title?count=100';

		if ($input['minVotes'])
		{
			$url .= "num_votes={$input['minVotes']},";
		}
		
		$url .= '&title_type=feature,tv_movie,tv_series,tv_special,mini_series,documentary&sort=num_votes';

		if ($input['from'] && $input['to'])
		{
			$url .= "&release_date={$input['from']},{$input['to']}";
		}

		if ($input['minRating'])
		{
			$url .= "&user_rating={$input['minRating']},";
		}

		if ($input['offset'])
		{
			$url .= "&start={$input['offset']}/";
		}
		else
		{
			$url .= "&start=1/";
		}

		return $url;
	}
}