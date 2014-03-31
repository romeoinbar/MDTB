<?php namespace Lib\Repository\Season;
 
use Illuminate\Support\ServiceProvider;
 
class SeasonServiceProvider extends ServiceProvider {
 
    public function register()
    {
        $this->app->bind(
            'Lib\Repository\Season\SeasonRepositoryInterface',
            'Lib\Repository\Season\DbSeason'
        );
    }
 
}