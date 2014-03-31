<?php namespace Lib\Repository\Group;
 
use Illuminate\Support\ServiceProvider;
 
class GroupServiceProvider extends ServiceProvider {
 
    public function register()
    {
        $this->app->bind(
            'Lib\Repository\Group\GroupRepositoryInterface',
            'Lib\Repository\Group\SentryGroup'
        );
    }
 
}