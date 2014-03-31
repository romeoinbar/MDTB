<?php namespace Lib\Repository\Episode;
 
use Illuminate\Support\ServiceProvider;
 
class EpisodeServiceProvider extends ServiceProvider {
 
    public function register()
    {
        $this->app->bind(
            'Lib\Repository\Episode\EpisodeRepositoryInterface',
            'Lib\Repository\Episode\DbEpisode'
        );
    }
 
}