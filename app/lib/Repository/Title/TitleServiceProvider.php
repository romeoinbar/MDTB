<?php namespace Lib\Repository\Title;
 
use Illuminate\Support\ServiceProvider;
 
class TitleServiceProvider extends ServiceProvider {
 
    public function register()
    {
        $this->app->bind(
            'Lib\Repository\Title\TitleRepositoryInterface',
            'Lib\Repository\Title\DbTitle'
        );
    }
 
}