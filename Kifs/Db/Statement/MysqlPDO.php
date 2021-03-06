<?php
namespace Kifs\Db\Statement;

class MysqlPDO extends Statement
{
	/**
	 * @var PDOStatement
	 */
	protected $_stmt;


	public function execute($params)
	{
		$this->_stmt->execute($params);
	}

	public function fetch($fetchMode = \Kifs\Db\Connection::FETCH_ASSOC)
	{
		return $this->_stmt->fetch(\Kifs\Db\MysqlPDO::getFetchMode($fetchMode));
	}

	public function fetchAll($fetchMode = \Kifs\Db\Connection::FETCH_ASSOC)
	{
		return $this->_stmt->fetchAll(\Kifs\Db\MysqlPDO::getFetchMode($fetchMode));
	}

}
