<?php namespace Lib\Repository\Review;
 
use Illuminate\Support\ServiceProvider;
 
class ReviewServiceProvider extends ServiceProvider {
 
    public function register()
    {
        $this->app->bind(
            'Lib\Repository\Review\ReviewRepositoryInterface',
            'Lib\Repository\Review\DbReview'
        );
    }
 
}