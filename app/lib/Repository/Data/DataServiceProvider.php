<?php namespace Lib\Repository\Data;
 
use DB, Exception, App;
use Illuminate\Support\ServiceProvider;

 
class DataServiceProvider extends ServiceProvider
{
    public function register()
    {
        //ask for data provider from options singleton
        $options = App::make('Options');
        $provider = $options->getDataProvider();
       
        //get correct provider name
        if ($provider === 'imdb')
        {
            $impl = 'ImdbData';
        }
        elseif ($provider === 'tmdb')
        {
            $impl = 'TmdbData';
        }
        elseif ($provider === 'db')
        {
            $impl = 'DbData';
        }
        else
        {
            $impl = 'ImdbData';
        }
 
        $this->app->bind(
            'Lib\Repository\Data\DataRepositoryInterface',
            "Lib\Repository\Data\\$impl"
        );
    }
}