<?php
namespace Model;

class Dummy
{
	/**
	 * @var \Kifs\Db\Mysql
	 */
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function getMessagesByUser($username)
	{
		$sql = "SELECT *
				FROM dummy
				WHERE user = ".mysql_real_escape_string($username);

		return $this->db->query($sql);
	}

}
