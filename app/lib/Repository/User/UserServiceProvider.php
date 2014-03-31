<?php namespace Lib\Repository\User;
 
use Illuminate\Support\ServiceProvider;
 
class UserServiceProvider extends ServiceProvider {
 
    public function register()
    {
        $this->app->bind(
            'Lib\Repository\User\UserRepositoryInterface',
            'Lib\Repository\User\SentryUser'
        );
    }
 
}