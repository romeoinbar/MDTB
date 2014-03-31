<?php namespace Lib\Services\Search;

class DbSearch implements SearchProviderInterface
{
	/**
	 * Searches for a title by query.
	 *
	 * @param  string $query
	 * @return array
	 */
	public function byQuery($query)
	{
		$q = $this->prepareQuery($query);

	    return \Title::search($q);
	}

	/**
	 * Prepares users search term to be run
	 * against database records.
	 * 
	 * @param  string $query
	 * @return string
	 */
	private function prepareQuery($query)
	{
		$query = preg_replace("/[^A-Za-z0-9]/i", '%', $query);
		
		return "%$query%";
	}
}