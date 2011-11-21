<?php
namespace Kifs\Db;


abstract class Mysql
{
	const FETCH_ASSOC = \PDO::FETCH_ASSOC;

	abstract public function connect($host, $login, $pass, $db);

	abstract public function query($sql, $fetchMode);

	abstract public function exec($sql);

	abstract public function prepare($sql);
}
