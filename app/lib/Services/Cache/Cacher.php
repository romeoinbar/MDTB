<?php namespace Lib\Services\Cache;

use File;
use Illuminate\Cache\CacheManager;

class Cacher
{

	/**
	 * Cache provided data if not already cached,
	 * if it is already cached return data.
	 * 
	 * @param string $section
	 * @param string $key
	 * @param mixed $data
	 */
	public function add($section, $key, $data)
	{
		if ( $res = $this->get($section, $key) )
		{
			return $res;
		}
		else
		{
			$this->put($section, $key, $data);

			return $data;
		}
	}

	/**
	 * Get data from cache by section and key.
	 * 
	 * @param  string $section
	 * @param  string $key
	 * @return mixed
	 */
	public function get($section, $key)
	{
		$folders = array_slice(str_split($hash = md5($key), 2), 0, 2);
	    $path = app_path() . '/storage/cache/'. $section .'/' . implode('/', $folders) . '/' . $hash;

	    if( File::exists( $path ) )
	    {
	    	return unserialize(File::get($path));
	    }

	    return false;
	}

	/**
	 * Put data into cache.
	 * 
	 * @param  string $section
	 * @param  string $key
	 * @param  mixed  $content
	 * @return mixed
	 */
	public function put($section, $key, $content)
	{
		$folders = array_slice(str_split($hash = md5($key), 2), 0, 2);
	    $path = app_path() . '/storage/cache/'. $section .'/' . implode('/', $folders) . '/' . $hash;

	    if ( ! File::isDirectory($directory = dirname($path)))
	    {
	        File::makeDirectory($directory, 0777, true);
	    }

	    File::put($path, serialize($content));
	}

}