<?php

use Lib\Repository\Season\SeasonRepositoryInterface as Srepo;
use Lib\Services\Validation\SeasonValidator;

class SeriesSeasonsController extends TitleController
{
    /**
     * Season repository instance.
     * 
     * @var Lib\Repository\Season\SeasonRepositoryInterface
     */
    private $season;

    /**
     * Season validator instance.
     * 
     * @var Lib\Services\Validation\SeasonValidator
     */
    private $seasonValidator;

	public function __construct(Srepo $season, SeasonValidator $seasonValidator)
	{
        parent::__construct();

        $this->season = $season;
        $this->seasonValidator = $seasonValidator;
	}

    /**
     * Show episodes list for a season.
     * 
     * @param  string $title  series title
     * @param  int    $num    season number
     * @return View
     */
    public function show($title, $num)
    {
        if ($num == 0) App::abort(404);

        $title = $this->season->withSeasonsEpisodes($title);

        $title = $this->season->prepareSingle($title, $num);
        
        return View::make('Titles.EpisodeList')->withNum($num)->withData($title);
    }

    /**
     * Displays the page for creating a new season.
     *
     * @param  string/int $id 
     * @return View
     */
    public function create($id)
    {
        $series = $this->title->byId($id);

        return View::make('Titles.CreateSeason')->withSeries($series);
    }

    /**
     * Stores newly created season in database.
     *
     * We'll use this method for updating seasons
     * aswell because we're updating on duplicate key.
     *
     * @return Redirect
     */
    public function store($series)
    {
        $input = Input::except('_token');

        if ( ! $this->seasonValidator->with($input)->passes())
        {
            if (Request::ajax())
            {           
                return Helpers::compileErrorsForAjax( $this->seasonValidator->errors()->all() );
            }

            return Redirect::back()->withErrors($this->seasonValidator->errors())->withInput($input);
        }

        $this->season->create($input);

        if (Request::ajax())
        {
            return 'success';
        }

        return Redirect::back()->withSuccess( trans('main.season create success') );
    }

    /**
     * Deletes specified season.
     * @param  string $series
     * @param  string $season
     * @return Redirect
     */
    public function destroy($series, $season)
    {
        $this->season->delete($series, $season);

        return Redirect::back()->withSuccess( trans('main.deleted season success') );
    }

    /**
     * Updates specified season.
     * 
     * @param  string $series
     * @param  string $season
     * @return Redirect
     */
    public function update($series, $season)
    {
        $input = Input::except('_token');

        if ( ! $this->seasonValidator->with($input)->passes())
        {
            return Redirect::back()->withErrors($this->seasonValidator->errors())->withInput($input);
        }

        $this->season->create();
    }
}