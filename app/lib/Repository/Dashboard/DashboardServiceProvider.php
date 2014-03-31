<?php namespace Lib\Repository\Dashboard;
 
use Illuminate\Support\ServiceProvider;
 
class DashboardServiceProvider extends ServiceProvider {
 
    public function register()
    {
        $this->app->bind(
            'Lib\Repository\Dashboard\DashboardRepositoryInterface',
            'Lib\Repository\Dashboard\Dashboard'
        );
    }
 
}