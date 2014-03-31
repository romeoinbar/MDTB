<?php namespace Lib\Repository\Actor;
 
use Illuminate\Support\ServiceProvider;
 
class ActorServiceProvider extends ServiceProvider {
 
    public function register()
    {
        $this->app->bind(
            'Lib\Repository\Actor\ActorRepositoryInterface',
            'Lib\Repository\Actor\DbActor'
        );
    }
 
}