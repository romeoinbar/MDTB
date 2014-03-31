<?php namespace Lib\Services\Scraping;

use Lib\Services\Db\Writer;
use Lib\Services\Scraping\Scraper;
use Symfony\Component\DomCrawler\Crawler;

class NewsScraper extends Curl
{
	/**
	 * Array of scraped news.
	 * 
	 * @var array
	 */
	private $news;

	/**
	 * Writer instance.
	 * 
	 * @var Lib\Services\Db\Writer
	 */
	private $dbWriter;

	public function __construct(Writer $dbWriter)
	{
		$this->dbWriter = $dbWriter;
	}

	/**
	 * Scrapes news from all sources and saves to db.
	 * @return void
	 */
	public function all()
	{
		$this->getFromScreenRant()->save();
	}

	/**
	 * Scrapes and compiles news for saving from
	 * screenrant.com website.
	 * 
	 * @return self
	 */
	private function getFromScreenRant()
	{
		$compiledNews = array();

		$news = $this->curl('http://screenrant.com/archive/');
		
		$crawler = new Crawler($news);
		
		//first we'll grab every news item on the page
		foreach ($crawler->filter('div#content > ul > li') as $k => $node)
		{
			$cr = new Crawler($node);

			//then we will compile array out of every new items
			$compiledNews[$k] = array(
				'title'    => head($cr->filter('div > h2 > a')->extract(array('_text'))),
				'image'	   => head($cr->filter('div > a > img')->extract(array('src'))),
				'body'     => head($cr->filter('div > p')->extract(array('_text'))),
				'full_url' => head($cr->filter('div > h2 > a')->extract(array('href'))),
				'source'   => 'ScreenRant',
				'fully_scraped' => 0,
				);
		}

		$this->news = $compiledNews;

		return $this;
	}

	/**
	 * Saves scraped news to the database.
	 * 
	 * @return void
	 */
	private function save()
	{
		$this->dbWriter->compileBatchInsert('news', $this->news)
					   ->save();
	}

	/**
	 * Scrapes single news item from screenrant
	 * 
	 * @param  string $url
	 * @return string
	 */
	public function getSingleFromScreenRant($url)
	{
		
		$text = '';	
		$item = $this->curl($url);
		
		$crawler = new Crawler($item);

		$html = $crawler->filter('div[itemprop="articleBody"] p')->each(function (Crawler $node, $i)
		{
		    $ht = trim($node->html());

		    //filter out unneeded html
		    if (strpos($ht, 'contentjumplink')) return false;
		    if (strpos($ht, 'type="button"')) return false;
		    if (strpos($ht, 'type="hidden"')) return false;
		    if (strpos($ht, 'AD BLOCK')) return false;
		    
		   
		    if (strpos($ht, 'src='))
		    {
		    	preg_match('/.*?<img src="(.*?)"/', $ht, $m);
		    	
		    	if (isset($m[1]))
		    	{
		    		return "<img src='{$m[1]}' class='img-responsive'/>";
		    	}
		    }

		    return '<p>' . preg_replace('/<a.*?>(.*?)<\/a>/', '$1', $ht) . '</p>';	    
		});
		
		return trim(implode('', $html));
	}
}