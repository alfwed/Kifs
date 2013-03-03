<?php
namespace Kifs\Db;

interface Connection
{
	const FETCH_ASSOC = 1;

	const FETCH_BOTH = 2;


	/**
	 * Open a connection to the database
	 *
	 * @param string $host
	 * @param string $login
	 * @param string $pass
	 * @param string $db
	 */
	public function connect($host, $login, $pass, $db);

	/**
	 * Run the query $sql and returns the resulting statement
	 *
	 * @param string $sql
	 * @param int $fetchMode
	 * @return \Kifs\Db\Statement\Statement
	 */
	public function query($sql, $fetchMode);

	/**
	 * Execute the query $sql
	 *
	 * @param string $sql
	 */
	public function exec($sql);

	/**
	 * Prepare the query $sql and returns the resulting statement
	 *
	 * @param string $sql
	 * @return \Kifs\Db\Statement\Statement
	 */
	public function prepare($sql);

	/**
	 * Return the id of the last inserted line
	 *
	 * @param string $name
	 * @return int
	 */
	public function lastInsertId($name = null);

	public function beginTransaction();

	public function commit();

	public function rollBack();
}
