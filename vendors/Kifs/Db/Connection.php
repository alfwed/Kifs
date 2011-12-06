<?php
namespace Kifs\Db;

interface Connection
{
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
	 */
	public function prepare($sql);
}
