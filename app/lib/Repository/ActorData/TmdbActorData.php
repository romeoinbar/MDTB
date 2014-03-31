<?php namespace Lib\Repository\ActorData;

use Carbon\Carbon;
use Actor, App, Exception, Helpers;
use Lib\Repository\Data\TmdbData;
use Symfony\Component\DomCrawler\Crawler;

class TmdbActorData extends TmdbData implements ActorDataRepositoryInterface
{
	/**
	 * Unformatted actor information.
	 * 
	 * @var array
	 */
	private $data;

	/**
	 * Actors general information.
	 * 
	 * @var array
	 */
	private $genInfo;

	/**
	 * Actors biography.
	 * 
	 * @var string
	 */
	private $bio;

	/**
	 * Actors biography link.
	 * 
	 * @var string
	 */
	private $bioLink;

	/**
	 * Actors image url.
	 * 
	 * @var string
	 */
	private $image;

	/**
	 * Actors name.
	 * 
	 * @var string
	 */
	private $actorName;

	/**
	 * Title actor is known for.
	 * 
	 * @var array
	 */
	private $knownFor;

	/**
	 * Actors birthplace.
	 * 
	 * @var string
	 */
	private $birthPlace;

	/**
	 * Actors birthdate.
	 * 
	 * @var string
	 */
	private $birthDate;

	/**
	 * Actors filmography.
	 * 
	 * @var array
	 */
	private $filmo;

	/**
	 * Actors tmdbid.
	 * 
	 * @var string
	 */
	private $tmdbid;

	/**
	 * Actors imdbid.
	 * 
	 * @var string
	 */
	private $imdbid;

	/**
	 * Gets general information about the actor.
	 * 
	 * @return array
	 */
	public function getGenInfo()
	{
		if ( ! $this->genInfo)
		{
			$this->genInfo = array(
				'name'   		=> $this->getName(),
				'imdb_id'		=> $this->imdbid,
				'tmdb_id'		=> $this->tmdbid,
				'image'  		=> $this->getImage(),
				'bio'    		=> $this->getBio(),
				'full_bio_link' => $this->getBioLink(),
				'birth_date'    => $this->getBirthDate(),
				'birth_place'   => $this->getBirthPlace()
			);
		}

		return $this->genInfo;
	}

	/**
	 * Gets Actors name.
	 * 
	 * @return string.
	 */
	public function getName()
	{
		if ( ! $this->actorName)
		{
			$this->actorName = $this->data[0]['name'];
		}

		return $this->actorName;
	}

	/**
	 * Gets Actors birth date.
	 * 
	 * @return string.
	 */
	public function getBirthDate()
	{
		if ( ! $this->birthDate)
		{
			$this->birthDate = $this->data[0]['birthday'];

		}

		return $this->birthDate;
	}

	/**
	 * Gets Actors birth place.
	 * 
	 * @return string.
	 */
	public function getBirthPlace()
	{
		if ( ! $this->birthPlace)
		{
			$this->birthPlace = $this->data[0]['place_of_birth'];

		}

		return $this->birthPlace;
	}

	/**
	 * Gets Actors filmographuy.
	 * 
	 * @return array.
	 */
	public function getFilmography()
	{
		if ( ! $this->filmo)
		{
			//extract id, title, poster for each one and make multidim array from it
			foreach ($this->data[1]['cast'] as $k => $v)
			{
				$type   = ($v['media_type'] == 'movie' ? 'movie' : 'series');
				$poster = ( ! $v['poster_path'] ? null : $this->imgBase . 'w342' . $v['poster_path']); 
				$title  = ( isset($v['name']) ? $v['name'] : $v['title']);
				$rd     = ( isset($v['release_date']) ? $v['release_date'] : $v['first_air_date']);
				$year   = Helpers::extractYear($rd);

				$this->filmo[] = array('tmdb_id' => $v['id'], 'title' => $title, 'year' => $year,
								  'poster' => $poster, 'type' => $type, 'release_date' => $rd ? $rd : Carbon::now()->addYear()->year);
			}
		}
		
		return $this->filmo;
	}

	/**
	 * Gets Actors image.
	 * 
	 * @return string.
	 */
	public function getImage()
	{
		if ( ! $this->image)
		{
			$this->image = $this->data[0]['profile_path'] ? $this->imgBase . 'w342' . $this->data[0]['profile_path'] : null;
		}

		return $this->image;
	}

	/**
	 * Gets Actors biography.
	 * 
	 * @return string.
	 */
	public function getBio()
	{
		if ( ! $this->bio)
		{
			$this->bio = $this->data[0]['biography'];
		}

		return $this->bio;
	}

	/**
	 * Gets Actors full biography url.
	 * 
	 * @return string.
	 */
	public function getBioLink()
	{
		if ( ! $this->bioLink)
		{
			$this->bioLink = 'http://www.themoviedb.org/person/' . $this->tmdbid;
		}

		return $this->bioLink;
	}

	/**
	 * Gets titles actor is know for.
	 * 
	 * @return array.
	 */
	public function getKnownFor()
	{		
		if ( ! $this->knownFor)
		{
			//extract id, title, poster for each one and make multidim array from it
			foreach (array_slice($this->data[1]['cast'], 0, 4) as $k => $v)
			{
				$type   = ($v['media_type'] == 'movie' ? 'movie' : 'series');
				$poster = ( ! $v['poster_path'] ? '' : $this->imgBase . 'w342' . $v['poster_path']);
				$title  = ( isset($v['name']) ? $v['name'] : $v['title']);
				$rd     = ( isset($v['release_date']) ? $v['release_date'] : $v['first_air_date']);
				$year   = Helpers::extractYear($rd);

				$this->knownFor[] = array('tmdb_id' => $v['id'], 'title' => $title, 'year' => $year,
								  'poster' => $poster, 'type' => $type, 'release_date' => $rd ? $rd : Carbon::now()->addYear()->year);
			}
		}

		return $this->knownFor;
	}

	/**
	 * Fetches provided actors full info from tmdb.
	 * 
	 * @param  actor model $actor 
	 * @return self
	 */
	public function getActor(Actor $actor)
	{
		if ( ! $actor->imdb_id && ! $actor->tmdb_id)
		{
			throw new Exception ('Couldn\'t find neither tmdb_id nor imdb_id on actor model');
		}

		//if we don't find tmdbid on passed model we'll forward the
		//request to imdb parser instead
		if ( ! $actor->tmdb_id)
		{
			return App::make('Lib\Repository\ActorData\ImdbActorData')->getActor($actor);
		}

		$urls = $this->compileActorUrls($actor);
		$this->data = $this->fetchActorInfo($urls);
		$this->tmdbid = $this->data[0]['id'];
		$this->imdbid = $this->data[0]['id'];

		return $this;
	}

	/**
	 * Compiles actors general info and credits urls.
	 * 
	 * @param  actor  $actor
	 * @return array
	 */
	private function compileActorUrls(actor $actor)
	{
		$lang = App::make('Options')->getTmdbLang();

		$gen     = $this->base . 'person/' . $actor->tmdb_id . '?' . $this->key . "&language={$lang}";
		$credits = $this->base . 'person/' . $actor->tmdb_id . '/combined_credits' . '?' . $this->key . "&language={$lang}";

		return array($gen, $credits);
	}

	/**
	 * Fetches information about actor.
	 * 
	 * @param  array $urls
	 * @return array
	 */
	private function fetchActorInfo(array $urls)
	{
		foreach ($urls as $v)
		{
			$actorInfo[] = json_decode($this->call($v), true);
		}

		return $actorInfo;
	}
}