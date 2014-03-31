<?php namespace Lib\Repository\Lists;

use User, App;
use Lib\Services\Db\Writer;

class DbLists implements ListsRepositoryInterface
{

	/**
	 * DB writer instanace.
	 * 
	 * @var Lib\Services\Db\Writer
	 */
	protected $dbWriter;

	/**
	 * DB instance.
	 * 
	 * @var DB
	 */
	protected $db;

	public function __construct(Writer $dbWriter)
	{
		$this->dbWriter = $dbWriter;
		$this->db   = App::make('db');
	}

	/**
	 * Adds given title to given list of user.
	 *
	 * @param  array $input
	 * @return void
	 */
	public function add(array $input)
	{
		$data = array(
			'user_id' => $input['user'],
			'title_id' => $input['title'],
			$input['list'] => 1
			);

		$this->dbWriter->compileInsert('users_titles', $data)->save();
	}

	/**
	 * Removes given title from given list of user.
	 *
	 * @param  array $input 
	 * @return  String/Redirect
	 */
	public function remove(array $input)
	{
		$this->db->table('users_titles')
			->where('title_id', $input['title'])
			->where('user_id', $input['user'])
			->where($input['list'], 1)
			->delete();	
	}
}