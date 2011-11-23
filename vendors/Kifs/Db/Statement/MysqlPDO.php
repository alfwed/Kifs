<?php
namespace Kifs\Db\Statement;

class MysqlPDO
{
	/**
	 * @var PDOStatement
	 */
	private $_stmt;


	public function __construct($stmt)
	{
		$this->_stmt = $stmt;
	}

	public function execute($params)
	{
		$this->_stmt->execute($params);
	}

	public function fetch($fetchMode = \Kifs\Db\Mysql::FETCH_ASSOC)
	{
		return $this->_stmt->fetch($fetchMode);
	}

	public function fetchAll($fetchMode = \Kifs\Db\Mysql::FETCH_ASSOC)
	{
		return $this->_stmt->fetchAll($fetchMode);
	}

}
