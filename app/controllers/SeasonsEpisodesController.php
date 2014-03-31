<?php

use Lib\Services\Presentation\DbPresenter;
use Lib\Services\Validation\EpisodeValidator;
use Lib\Repository\Episode\EpisodeRepositoryInterface as EpRepo;

class SeasonsEpisodesController extends TitleController
{
    /**
     * Episode repository instance.
     * 
     * @var Lib\Repository\Episode\EpisodeRepositoryInterface
     */
    private $episode;

    /**
     * Episode validator instance.
     * 
     * @var Lib\Services\Validation\EpisodeValidator
     */
    private $epValidator;

	public function __construct(EpisodeValidator $epValidator, EpRepo $episode)
	{
        parent::__construct();

        $this->episode = $episode;
        $this->epValidator = $epValidator;
	}

    /**
     * Stores newly created episode in database.
     *
     * @param  string $series
     * @param  string $season
     * @param  string $episode
     *
     * @return Redirect
     */
    public function store($series, $season)
    {
        $input = Input::except('_token');

        if ( ! $this->epValidator->with($input)->passes())
        {
            if (Request::ajax())
            {           
                return Helpers::compileErrorsForAjax( $this->epValidator->errors()->all() );
            }

            return Redirect::back()->withErrors($this->epValidator->errors())->withInput($input);
        }

        $this->episode->create($input);

        if (Request::ajax())
        {
            return 'success';
        }

        return Redirect::back()->withSuccess( trans('main.ep create success') );
    }

    /**
     * Displays the page for creating a new episode.
     *
     * @param  string $id
     * @return View
     */
    public function create($series, $season)
    {
        $data = $this->title->byId($series);
        $data = new DbPresenter($data);

        return View::make('Titles.CreateEpisode')->withData($data)->withNum($season);
    }

    /**
     * Updates specified season.
     * 
     * @param  string $series
     * @param  string $season
     * @param  string $episode
     * 
     * @return Redirect
     */
    public function update($series, $season, $episode)
    {
        $input = Input::except('_token', '_method');

        if ( ! $this->epValidator->with($input)->passes())
        {
            if (Request::ajax())
            {           
                return Helpers::compileErrorsForAjax( $this->epValidator->errors()->all() );
            }

            return Redirect::back()->withErrors($this->epValidator->errors())->withInput($input);
        }

        $this->episode->create($input);

        if (Request::ajax())
        {
            return 'success';
        }

        return Redirect::back()->withSuccess( trans('main.ep update success') );
    }

    /**
     * Deletes specified episode.
     * 
     * @param  string $series
     * @param  string $season
     * @param  string $episode
     * 
     * @return Redirect
     */
    public function destroy($series, $season, $episode)
    {
        $this->episode->delete($episode);

        return Redirect::back()->withSuccess( trans('main.delete success') );
    }
}