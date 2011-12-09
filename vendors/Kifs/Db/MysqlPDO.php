<?php
namespace Kifs\Db;

/**
 * FIXME Hide class constants : function getFetchMode($kifs_fetch_mode)
 */
class MysqlPDO implements Connection
{
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

		$this->_con->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,
				$this->getFetchMode(Connection::FETCH_ASSOC));
	}

	public function query($sql, $fetchMode = Connection::FETCH_ASSOC)
	{
		return new \Kifs\Db\Statement\MysqlPDO($this->_con->query($sql,
				$this->getFetchMode($fetchMode)));
	}

	public function exec($sql)
	{
		return $this->_con->exec($sql);
	}

	public function prepare($sql)
	{
		return new \Kifs\Db\Statement\MysqlPDO($this->_con->prepare($sql));
	}

	public static function getFetchMode($connectionFetchMode)
	{
		switch ($connectionFetchMode) {
			case Connection::FETCH_ASSOC:
				return PDO::FETCH_ASSOC;
			case Connection::FETCH_BOTH:
				return PDO::FETCH_BOTH;
			default:
				throw new \Exception('Unknown fetch mode "'.$connectionFetchMode.'"');
		}
	}

}
