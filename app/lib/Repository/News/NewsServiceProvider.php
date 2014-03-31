<?php namespace Lib\Repository\News;
 
use Illuminate\Support\ServiceProvider;
 
class NewsServiceProvider extends ServiceProvider {
 
    public function register()
    {
        $this->app->bind(
            'Lib\Repository\News\NewsRepositoryInterface',
            'Lib\Repository\News\DbNews'
        );
    }
 
}