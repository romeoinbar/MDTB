<?php namespace Lib\Services\Cache;
 
use Event, App, File;
use Illuminate\Support\ServiceProvider;
 
class CacheInvalidationServiceProvider extends ServiceProvider {
 
    /**
     * Cacher instance.
     * 
     * @var Lib\Services\Cache\Cacher
     */
    private $cache;

    public function __construct()
    {
        $this->cache = App::make('Lib\Services\Cache\Cacher');
    }

    public function register(){}

    public function boot()
    {
        //clear news cache 
        Event::listen('News.*', function($time)
        {    	
        	$dirs[] = storage_path('cache/news');
        	$dirs[] = storage_path('cache/pagi_news');
        	
        	foreach ($dirs as $k => $v)
        	{
        		File::cleanDirectory($v);
        	}
        });

        //clean all cache
        Event::listen('DB.Truncated', function()
        {
            $dir = storage_path('cache');
            File::cleanDirectory($dir);
        });

        //clean featured movies cache
        Event::listen('Titles.*', function()
        {
            $dirs[] = storage_path('cache/featured');
            $dirs[] = storage_path('cache/playing');

            foreach ($dirs as $k => $v)
            {
                File::cleanDirectory($v);
            }
        
        });
    }
 
}