<?php namespace Lib\Repository\Dashboard;

use Lib\Services\Db\Writer;
use Lib\Repository\Title\DbTitle;
use Event, View, Sentry, Groups, DB, File;

class Dashboard implements DashboardRepositoryInterface
{
	/**
	 * Tmdb instance.
	 * 
	 * @var Lib\Parsers\TmdbParser
	 */
	private $tmdb;

	/**
	 * Stores now playing movies.
	 * 
	 * @var array
	 */
	public $nowPlaying = array();

	/**
	 * dbWriter instance.
	 * 
	 * @var Lib\Services\Db\Writer
	 */
	private $dbWriter;

	/**
	 * title instance.
	 * 
	 * @var Lib\Repository\Title\DbTitle
	 */
	private $title;

	/**
	 * Instantiates dependecies.
	 * 
	 * @param TmdbParser $tmdb
	 */
	public function __construct(Writer $dbWriter, DbTitle $title)
	{
		$this->dbWriter 	  = $dbWriter;
		$this->title 		  = $title;
	}

	/**
	 * Renders user mini profile partial view.
	 * 
	 * @param  array $input
	 * @return string
	 */
	public function makeMiniProfile($input)
	{
		$user = Sentry::findUserByLogin( $input['username'] );

		$groups = Groups::orderBy('created_at', 'DESC')->get();

		return View::make('Dashboard.Partials.MiniProfile')->withUser($user)->withGroups($groups)->render();
	}

	/**
	 * Updates options in db.
	 * 
	 * @param  array  $options
	 * @return void
	 */
	public function updateOptions(array $options)
	{
		foreach ($options as $k => $v)
		{
			$insert[$k] = $v;		
		}

		$this->dbWriter->updateOptions($insert);
	}

	/**
	 * Truncates database and file system of all data.
	 * 
	 * @return void
	 */
	public function truncate()
	{
		ini_set('max_execution_time', 0);

		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		DB::table("writers_titles")->truncate();
		DB::table("directors_titles")->truncate();
		DB::table("actors_titles")->truncate();
		DB::table("images")->truncate();
		DB::table("throttle")->truncate();
		DB::table("news")->truncate();
		DB::table("actors")->truncate();
		DB::table("directors")->truncate();
		DB::table("writers")->truncate();
		DB::table("reviews")->truncate();
		DB::table("episodes")->truncate();
		DB::table("seasons")->truncate();	
		DB::table("titles")->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
		
		File::cleanDirectory( storage_path() . '/cache' );
		File::cleanDirectory( public_path() . '/imdb/posters' );
		File::cleanDirectory( public_path() . '/imdb/bgs' );
		File::cleanDirectory( public_path() . '/imdb/stills' );
		File::cleanDirectory( public_path() . '/imdb/cast' );
		File::cleanDirectory( public_path() . '/imdb/episodes' );

		Event::fire('DB.Truncated');
	}
}