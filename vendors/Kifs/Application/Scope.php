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

	private $_tplDir;

	private $_publicDir;

	private $_configs;

	private $_env;

	private $_instances = array();


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
		if (isset($this->_databases[$name]))
			trigger_error('Database connection named "'.$name.'" was already registered', E_USER_WARNING);

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

	public function getTemplateDir()
	{
		return $this->_tplDir;
	}

	public function setTemplateDir($tplDir)
	{
		$this->_tplDir = $tplDir;
	}

	public function getPublicDir()
	{
		return $this->_publicDir;
	}

	public function setPublicDir($dir)
	{
		$this->_publicDir = $dir;
	}

	public function loadConfig($name)
	{
		if (isset($this->_configs[$name]))
			return;

		// Make these 3 variables  visible into the config files
		$appDir = $this->getAppDir();
		$tplDir = $this->getTemplateDir();
		$publicDir = $this->getPublicDir();

		$filenameCommon = $appDir.'/Config/'.$name.'.php';
		$filenameEnv = $appDir.'/Config/'.$this->getEnv().'/'.$name.'.php';

		if (file_exists($filenameCommon))
			$this->_configs[$name] = include $filenameCommon;
		elseif(file_exists($filenameEnv))
			$this->_configs[$name] = include $filenameEnv;
		else
			throw new Exception('Config file for "'.$name.'" does not exist');
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

	public function registerInstance($name, $obj)
	{
		if (!isset($this->_instances[$name]))
			$this->_instances[$name] = $obj;
	}

	public function getInstance($name)
	{
		if (isset($this->_instances[$name]))
			return $this->_instances[$name];

		return null;
	}

}
