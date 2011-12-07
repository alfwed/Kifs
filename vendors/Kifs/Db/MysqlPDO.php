<?php
namespace Kifs\Db;

/**
 * FIXME Hide class constants : return 'inject'.str_replace('\\', '', $controllerName);
 */
class MysqlPDO implements Connection
{
	const FETCH_ASSOC = \PDO::FETCH_ASSOC;

	/**
	 * @var PDO
	 */
	private $_con;


	public function __construct()
	{
	}

	public function connect($host, $login, $pass, $db)
	{
		$dsn = 'mysql:dbname='.$db.';host='.$host;
		try {
			$this->_con = new \PDO($dsn, $login, $pass);
		} catch (\PDOException $e) {
			throw new \Kifs\Db\ConnectionException($e->getMessage());
		}

		$this->_con->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, MysqlPDO::FETCH_ASSOC);
	}

	public function query($sql, $fetchMode = MysqlPDO::FETCH_ASSOC)
	{
		return new \Kifs\Db\Statement\MysqlPDO($this->_con->query($sql, $fetchMode));
	}

	public function exec($sql)
	{
		return $this->_con->exec($sql);
	}

	public function prepare($sql)
	{
		return new \Kifs\Db\Statement\MysqlPDO($this->_con->prepare($sql));
	}

}
