<?php namespace Lib\Services\Presentation;

use Title, Helpers, App, Str, Request;

class DbPresenter
{
	/**
	 * Title model instance.
	 * 
	 * @var Title
	 */
	public $model;

	/**
	 * Options instance.
	 * 
	 * @var Lib\Services\Options\Options
	 */
	public $options;

	public function __construct(Title $model)
	{
		$this->model = $model;
		$this->options = App::make('Options');
	}

	/**
	 * Returns titles id.
	 * 
	 * @return string
	 */
	public function getId()
	{
		return $this->model->id;
	}

	/**
	 * Returns titles title.
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		return $this->model->title;
	}

	/**
	 * Returns titles custom field.
	 * 
	 * @return string
	 */
	public function getCustomField()
	{
		return $this->model->custom_field;
	}

	/**
	 * Get titles tagline.
	 * 
	 * @return string
	 */
	public function getTagline()
	{
		return $this->model->tagline;
	}

	/**
	 * Get titles directors.
	 * 
	 * @return array
	 */
	public function getDirectors()
	{
		return $this->model->director->toArray();
	}

	/**
	 * Get title writers.
	 * 
	 * @return array
	 */
	public function getWriters()
	{
		return $this->model->writer->toArray();
	}

	/**
	 * Returns titles jumbotron background.
	 * 
	 * @return string
	 */
	public function getBackground()
	{
		//return generic image if no background found
		//on title
		if ( ! $this->model->background)
		{
			return 'assets/images/cinema.jpg';
		}

		return $this->model->background;
	}

	/**
	 * Returns titles runtime.
	 * 
	 * @return string
	 */
	public function getRuntime()
	{
		return $this->model->runtime;
	}

	/**
	 * Returns titles model.
	 * 
	 * @return Title
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * Returns titles type.
	 * 
	 * @return string
	 */
	public function getType()
	{
		return $this->model->type;
	}

	/**
	 * Returns titles release date.
	 * 
	 * @return string
	 */
	public function getReleaseDate()
	{
		return $this->model->release_date;
	}

	/**
	 * Returns titles budget
	 * 
	 * @return string
	 */
	public function getBudget()
	{
		if ($this->model->budget != '$0')
		{
			return $this->model->budget;
		}
	
	}

	/**
	 * Returns titles country
	 * 
	 * @return string
	 */
	public function getCountry()
	{
		return $this->model->country;
	}

	/**
	 * Returns titles language
	 * 
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->model->language;
	}

	/**
	 * Returns titles revenue
	 * 
	 * @return string
	 */
	public function getRevenue()
	{
		if ($this->model->revenue != '$0')
		{
			return $this->model->revenue;
		}
	}

	/**
	 * Returns titles metacritic rating.
	 * 
	 * @return string
	 */
	public function getMetaCriticRate()
	{
		return $this->model->metacritic_rating;
	}

	/**
	 * Returns titles imdb rating.
	 * 
	 * @return string
	 */
	public function getImdbRate()
	{
		return $this->model->imdb_rating;
	}

	/**
	 * Returns titles genres.
	 * 
	 * @return string
	 */
	public function getGenre()
	{
		$type = head(Request::segments());
		$genre = '';
		$split = explode('|', $this->model->genre);


		foreach ($split as $k => $v)
		{
			$genre .= '<a href="' . url(e($type)) . '?genre=' . Str::slug($v) . '">' . $v . '</a> |';
		}

		$genre = str_replace('genre=sci-fi', 'genre=sci', $genre);

		return rtrim($genre, ' |');
	}

	/**
	 * Returns titles poster.
	 * 
	 * @return string
	 */
	public function getPoster()
	{
		return $this->model->poster;
	}

	/**
	 * Returns titles metacritic user rating.
	 * 
	 * @return string
	 */
	public function getMcUserRate()
	{
		return $this->model->mc_user_score;
	}

	/**
	 * Returns titles metacritic user rating.
	 * 
	 * @return string
	 */
	public function getMcCriticRate($convert = '')
	{
		if ($convert == 'convert')
		{
			$num = $this->model->mc_critic_score;

			return preg_replace('/([0-9])([0-9])/', '$1.$2', $num);
		}

		return $this->model->mc_critic_score;
	}

	/**
	 * Returns titles images.
	 * 
	 * @return array
	 */
	public function getImages()
	{
		$images = array();

		foreach ($this->model->image->slice(0,6) as $img)
		{
			//if we've got images web url we'll use 
			//it to hotlink image
			if ($img->web)
			{
				$images[] = $img->web;
			}

			//otherwise we will use image that we downloaded locally.
			elseif ($img->local)
			{
				$images[] = $img->local;
			}
		}

		$count = count($images);

		//repeat images if we have less then 6
		if ($count < 6 && ! empty($images))
		{
			$duplicates = array_fill(0, 6 - $count, head($images));	
			$images = array_merge($images, $duplicates);
		}

		return (isset($images) ? $images : null);
	}

	/**
	 * Returns titles cast.
	 * 
	 * @return array
	 */
	public function getCast()
	{
		foreach ($this->model->actor as $k => $v)
		{
			if (strlen($v->image) < 1)
			{
				$v->image = 'assets/images/noimage.jpg';
			}
		}

		return $this->model->actor->toArray();
	}

	/**
	 * Returns titles critic reviews.
	 * 
	 * @return string
	 */
	public function getCriticReviews()
	{
		$compiled = $this->model->review->filter(function($review)
		{
			if ( ! $review->user_id)
			{
				return true;
			}
		});

		return $compiled->toArray();
	}

	/**
	 * Returns titles user reviews.
	 * 
	 * @return string
	 */
	public function getUserReviews()
	{

		$compiled = $this->model->review->filter(function($review)
		{
			if ($review->user_id)
			{
				return true;
			}
		});

		return $compiled->toArray();
	}

	/**
	 * Returns titles trailer.
	 * 
	 * @return string
	 */
	public function getTrailer()
	{
		return $this->model->trailer;
	}

	/**
	 * Returns titles plot.
	 * 
	 * @return string
	 */
	public function getPlot($len = null)
	{
		$plot = $this->model->plot;

		if ($len)
		{
			if (strlen($plot) > 400)
			{
				$plot = substr($plot, 0, 400) . '...';
			}
		}

		return $plot;
	}

	/**
	 * Returns titles seasonso or specified season.
	 *
	 * @param  mixed $num
	 * @return array
	 */
	public function getSeasons($num = null)
	{
		
		if ( ! $num)
		{
			return ( ! $this->model->season->isEmpty() ? $this->model->season : array());
		}

		return $this->getSpecificSeason($num, $this->model->season);		
	}

	/**
	 * Returns link to amazon dvd search with current title.
	 * 
	 * @return string
	 */
	public function getBuyLink()
	{
		$keyword = str_replace(' ', '+', $this->model->title) . "+{$this->model->null}";

		if ($link = $this->getAffiliateLink())
		{
			return $link;
		}
		elseif ($id = $this->options->getAmazonId())
		{
			return 'http://www.amazon.fr/s/?_encoding=UTF8&camp=1789&creative=390957&field-keywords='
				   . $keyword . '&rh=i%3Aaps%2Ck%3A'
				   . $keyword . "&tag=$id&url=search-alias%3Dfilms-serie";
		}
		else
		{
			return 'http://www.amazon.fr/s/?url=search-alias%3Ddvd&field-keywords=' . $this->model->title;
		}
	}

	/**
	 * Returns titles awards.
	 * 
	 * @return string
	 */
	public function getAwards()
	{
		return str_replace('.and', ' &amp; ', $this->model->awards);
	}

	/**
	 * Returns titles affiliate link if any.
	 * 
	 * @return string
	 */
	public function getAffiliateLink()
	{
		return $this->model->affiliate_link;
	}

	/**
	 * Returns titles rating in percentage format.
	 * 
	 * @return string/void
	 */
	public function getRating()
	{
		if ($this->model->imdb_rating)
		{
			$rating = round($this->model->imdb_rating) * 10 . '%';
		}
		elseif ($this->model->mc_user_score)
		{
			$rating = round($this->model->mc_user_score) * 10 . '%';
		}
		else
		{
			$rating = round($this->model->tmdb_rating) * 10 . '%';
		}

		return ($rating != '0%' ? $rating : null);
	}

	/**
	 * Returns titles metacritic rating.
	 * 
	 * @return string
	 */
	public function getMcRating()
	{
		return $this->model->mc_user_score;
	}

	/**
	 * Returns titles tmdb rating.
	 * 
	 * @return string
	 */
	public function getTmdbRating()
	{
		return $this->model->tmdb_rating;
	}

	/**
	 * Returns titles imdb rating.
	 * 
	 * @return string
	 */
	public function getImdbRating()
	{
		return $this->model->imdb_rating;
	}

	public function getJumboMenuColor()
	{
		//get the available rating
		$percent = $this->getRating();

		//get the color depending on rating
		if ($percent >= '70%' || $percent == '100%')
		{
			if ($dbColor = $this->options->getColor('success'))
			{
				$color = $dbColor;
			}
			else
			{
				$color = '#5D8C2E';
			}		
		}
		elseif ($percent < '70%' && $percent > '50%')
		{
			if ($dbColor = $this->options->getColor('warning'))
			{
				$color = $dbColor;
			}
			else
			{
				$color = '#CB8820';
			}				
		}
		else
		{
			if ($dbColor = $this->options->getColor('danger'))
			{
				$color = $dbColor;
			}
			else
			{
				$color = '#A43B2C'; //#DE6C69
			}						
		}

		return $color;
	}

	/**
	 * Returns title vote bar color depending on
	 * what votes are available and on their value.
	 * 
	 * @return string
	 */
	public function getVoteBarColor()
	{
		//get the available rating
		$percent = $this->getRating();

		//get the color depending on rating
		if ($percent >= '70%' || $percent == '100%')
		{
			$state = 'success';
		}
		elseif ($percent < '70%' && $percent > '50%')
		{
			$state = 'warning';
		}
		else
		{
			$state = 'danger';
		}

		return $state;
	}

	/**
	 * Returns requested season.
	 * 
	 * @param  int $num
	 * @param  collection $seasons
	 * @return collection
	 */
	private function getSpecificSeason($num, $seasons)
	{
		foreach ($seasons as $k => $v)
		{
			if ($v->number == $num)
			{
				return $v;
			}
		}
	}

	/** Returns movie Links grouped by Language
	 * 
	 */
	public function getMovieLinks() {
		return $this->model->links;
	}
}