<?php
namespace Kifs\Application;

class Scope
{
	/**
	 * @var array
	 */
	private $_posts;

	/**
	 * @var array
	 */
	private $_queries;

	/**
	 * @var array
	 */
	private $_cookies;

	/**
	 * @var array
	 */
	private $_server;

	/**
	 * Array of \Kifs\Db\Connection
	 *
	 * @var array
	 */
	private $_databases;


	/**
	 * @var string
	 */
	private $_appDir;

	/**
	 * @var string
	 */
	private $_tplDir;

	/**
	 * @var string
	 */
	private $_publicDir;

	/**
	 * Array of config files
	 *
	 * @var array
	 */
	private $_configs;


	/**
	 * @var string
	 */
	private $_env;

	/**
	 * @var string
	 */
	private $_country;

	/**
	 * @var string
	 */
	private $_language;


	private $_instances = array();


	/**
	 * @param array $posts
	 * @param array $queries
	 * @param array $cookies
	 * @param array $server
	 */
	public function __construct($posts, $queries, $cookies, $server)
	{
		$this->_posts = $posts;
		$this->_queries = $queries;
		$this->_cookies = $cookies;
		$this->_server = $server;
	}

	/**
	 * Returns POST variables
	 *
	 * @return array
	 */
	public function getPosts()
	{
		return $this->_posts;
	}

	/**
	 * Returns GET variables
	 *
	 * @return array
	 */
	public function getQueries()
	{
		return $this->_queries;
	}

	/**
	 * Returns COOKIE variables
	 *
	 * @return array
	 */
	public function getCookies()
	{
		return $this->_cookies;
	}

	/**
	 * Returns SERVER variables
	 *
	 * @return array
	 */
	public function getServer()
	{
		return $this->_server;
	}

	/**
	 * Returns the db connection stored as $name
	 *
	 * @param string $name
	 * @return \Kifs\Db\Connection
	 */
	public function getDbConnection($name)
	{
		if (isset($this->_databases[$name]))
			return $this->_databases[$name];

		return null;
	}

	/**
	 * Stores a db connection $db under the name $name
	 *
	 * @param string $name
	 * @param \Kifs\Db\Connection $db
	 * @return void
	 */
	public function addDbConnection($name, $db)
	{
		if (isset($this->_databases[$name]))
			trigger_error('Database connection named "'.$name.'" was already registered', E_USER_WARNING);

		$this->_databases[$name] = $db;
	}

	/**
	 * Returns the path to the application directory
	 *
	 * @return string
	 */
	public function getAppDir()
	{
		return $this->_appDir;
	}

	/**
	 * Sets the path to the application directory
	 *
	 * @param string $appDir
	 * @return void
	 */
	public function setAppDir($appDir)
	{
		$this->_appDir = $appDir;
	}

	/**
	 * Returns the path to the template directory
	 *
	 * @return string
	 */
	public function getTemplateDir()
	{
		return $this->_tplDir;
	}

	/**
	 * Sets the path to the template directory
	 *
	 * @param string $tplDir
	 * @return void
	 */
	public function setTemplateDir($tplDir)
	{
		$this->_tplDir = $tplDir;
	}

	/**
	 * Returns the path to the public directory
	 *
	 * @return string
	 */
	public function getPublicDir()
	{
		return $this->_publicDir;
	}

	/**
	 * Sets the path to the public directory
	 *
	 * @param string $dir
	 * @return void
	 */
	public function setPublicDir($dir)
	{
		$this->_publicDir = $dir;
	}

	/**
	 * Retrieves and stores the config file named $name
	 *
	 * @throws\Exception
	 * @param string $name
	 * @return void
	 */
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
			throw new \Exception('Config file for "'.$name.'" does not exist');
	}

	/**
	 * Returns the current environment
	 *
	 * @return string
	 */
	public function getEnv()
	{
		return $this->_env;
	}

	/**
	 * Sets the current environment
	 *
	 * @param string $env
	 * @return string
	 */
	public function setEnv($env)
	{
		$this->_env = $env;
	}

	/**
	 * Returns the current country
	 *
	 * @return string
	 */
	public function getCountry()
	{
		return $this->_country;
	}

	/**
	 * Sets the current country
	 *
	 * @param string $country
	 * @return void
	 */
	public function setCountry($country)
	{
		$this->_country = $country;
	}

	/**
	 * Returns the current language
	 *
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->_language;
	}

	/**
	 * Sets the current language
	 *
	 * @param string $language
	 * @return void
	 */
	public function setLanguage($language)
	{
		$this->_language = $language;
	}


	/**
	 * Returns the config for $name
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function getConfigs($name)
	{
		if (isset($this->_configs[$name]))
			return $this->_configs[$name];

		return null;
	}

	/**
	 * Returns the value for the key $key from the config array $name
	 *
	 * @param string $name
	 * @param string $key
	 * @return mixed
	 */
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
