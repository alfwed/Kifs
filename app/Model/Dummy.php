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
				WHERE user = '".$username."'";
//$sql = "SHOW TABLES";

		$stmt = $this->db->query($sql);
		return $stmt->fetchAll();

		$stmt = $this->db->prepare($sql);
		/* @var $stmt \Kifs\Db\Statement\MysqlPDO */
		$stmt->execute(array($username));

		return $stmt->fetch();
	}

}
