<?php
namespace Kifs\Application;

class Scope
{
	private $_posts;

	private $_queries;

	private $_cookies;

	private $_server;

	private $_databases;

	private $_appDir;

	private $_configs;

	private $_env;


	public function __construct($posts, $queries, $cookies, $server)
	{
		$this->_posts = $posts;
		$this->_queries = $queries;
		$this->_cookies = $cookies;
		$this->_server = $server;
	}

	public function getPosts()
	{
		return $this->_posts;
	}

	public function getQueries()
	{
		return $this->_queries;
	}

	public function getCookies()
	{
		return $this->_cookies;
	}

	public function getServer()
	{
		return $this->_server;
	}

	public function getDbConnection($name)
	{
		if (isset($this->_databases[$name]))
			return $this->_databases[$name];

		return null;
	}

	public function addDbConnection($name, $db)
	{
		// FIXME just raise a warning instead of exception
		if (isset($this->_databases[$name]))
			throw new Exception('Database '.$name.' was already registered');

		$this->_databases[$name] = $db;
	}

	public function getAppDir()
	{
		return $this->_appDir;
	}

	public function setAppDir($appDir)
	{
		$this->_appDir = $appDir;
	}

	public function loadConfig($name)
	{
		if (isset($this->_configs[$name]))
			return;

		$appDir = $this->getAppDir();
		$filename = $appDir.'/Config/'.$this->getEnv().'/'.$name.'.php';

		if (!file_exists($filename))
			return;

		$this->_configs[$name] = include $filename;
	}

	public function setEnv($env)
	{
		$this->_env = $env;
	}

	public function getEnv()
	{
		return $this->_env;
	}

	public function getConfigs($name)
	{
		if (isset($this->_configs[$name]))
			return $this->_configs[$name];

		return null;
	}

	public function getConfig($name, $key)
	{
		if (isset($this->_configs[$name][$key]))
			return $this->_configs[$name][$key];

		return null;
	}
}

