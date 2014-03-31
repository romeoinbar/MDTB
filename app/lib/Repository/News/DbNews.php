<?php namespace Lib\Repository\News;

use News, Event;
use Carbon\Carbon;
use Lib\Services\Db\Writer;
use Lib\Services\Scraping\NewsScraper;
use Lib\Repository\News\NewsRepositoryInterface;

class DbNews implements NewsRepositoryInterface
{
	/**
	 * Writer instance.
	 * 
	 * @var Lib\Services\Db\Writer
	 */
	private $dbWriter;

	/**
	 * News model instance.
	 * 
	 * @var News
	 */
	private $news;

	/**
	 * News scraper instance
	 * 
	 * @var Lib\Services\Scraping\NewsScraper
	 */
	private $scraper;

	/**
	 * Instantiate dependencies.
	 * 
	 * @param Scraper $scraper
	 */
	public function __construct(Writer $dbWriter, News $news, NewsScraper $scraper)
	{
		
		$this->news     = $news;
		$this->scraper  = $scraper;
		$this->dbWriter = $dbWriter;
	}

	/**
	 * Fetches the data needed to make news
	 * index page.
	 * 
	 * @return Collection
	 */
	public function index()
	{
		return $this->news->newsIndex();
	}
	

	/**
	 * Stores new news item to database.
	 * 
	 * @param  array $input
	 * @return void
	 */
	public function store(array $input)
	{
		foreach ($input as $k => $v)
		{
			$this->news->$k = $v;
		}

		$this->news->save();

		Event::fire('News.Created', Carbon::now());
	}

	/**
	 * Handles news item deletion.
	 * 
	 * @param  int/string $id
	 * @return void
	 */
	public function delete($id)
	{
		$this->news->destroy($id);

		Event::fire('News.Deleted', Carbon::now());
	}

	/**
	 * Handles news items fetching from db.
	 * 
	 * @param  int/string $id
	 * @return News model
	 */
	public function byId($id)
	{
		return $this->news->findOrFail($id);
	}

	/**
	 * Handles news items updating.
	 * 
	 * @param  News $news
	 * @param  array $input
	 * @return void
	 */
	public function update(News $news, array $input)
	{
		foreach ($input as $k => $v)
		{
			if ($k == 'updateTitle')
			{
				$news->title = $v;
			}
			else
			{
				$news->$k = $v;
			}		
		}

		$news->save();

		Event::fire('News.Updated', Carbon::now());
	}

	/**
	 * Get and save full news item body from screenrant.
	 * 
	 * @param  News   $news 
	 * @return News
	 */
	public function getFullNewsItem(News $news)
	{
		$html = $this->scraper->getSingleFromScreenRant($news->full_url);
		
		$news->body = $html;
		$news->fully_scraped = 1;
		$news->save();

		return $news;
	}
}