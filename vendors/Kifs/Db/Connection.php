<?php
namespace Kifs\Db;

interface Connection
{
	public function connect($host, $login, $pass, $db);

	public function query($sql, $fetchMode);

	public function exec($sql);

	public function prepare($sql);
}
