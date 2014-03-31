<?php namespace Lib\Repository\Lists;
 
use Illuminate\Support\ServiceProvider;
 
class ListsServiceProvider extends ServiceProvider {
 
    public function register()
    {
        $this->app->bind(
            'Lib\Repository\Lists\ListsRepositoryInterface',
            'Lib\Repository\Lists\DbLists'
        );
    }
 
}