<?php namespace Lib\Repository\ActorData;
 
use DB, Exception, App;
use Illuminate\Support\ServiceProvider;

 
class ActorDataServiceProvider extends ServiceProvider
{
    public function register()
    {
        //ask for data provider from options singleton
        $options = App::make('Options');
        $provider = $options->getDataProvider();
       
        //get correct provider name
        if ($provider === 'imdb')
        {
            $impl = 'ImdbActorData';
        }
        else
        {
            $impl = 'TmdbActorData';
        }
 
        $this->app->bind(
            'Lib\Repository\ActorData\ActorDataRepositoryInterface',
            "Lib\Repository\ActorData\\$impl"
        );
    }
}