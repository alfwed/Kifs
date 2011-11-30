<?php
namespace Kifs\Db;


/**
 * @deprecated
 */
abstract class Mysql
{
	abstract public function connect($host, $login, $pass, $db);

	abstract public function query($sql, $fetchMode);

	abstract public function exec($sql);

	abstract public function prepare($sql);
}
