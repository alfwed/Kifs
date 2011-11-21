<?php
namespace Model;

class Dummy
{
	/**
	 * @var Kifs\Db\Mysql
	 */
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function getPosts()
	{

	}

}
