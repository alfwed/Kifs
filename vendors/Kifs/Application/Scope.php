<?php
namespace Kifs\Application;

/**
 * TODO Maybe create a Context class for env, country and language
 */
class Scope
{
	/**
	 * @var \Kifs\Application\ConfigLoader
	 */
	private $_configLoader;

	/**
	 * @var \Kifs\Application\Path
	 */
	private $_path;


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
	 * Set the loader to use to load
	 *
	 * @param ConfigLoader $loader
	 */
	public function setConfigLoader($loader)
	{
		$this->_configLoader = $loader;
	}

	public function getPath()
	{
		return $this->_path;
	}

	public function setPath($path)
	{
		$this->_path = $path;
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
	 * @deprecated
	 * @return string
	 */
	public function getAppDir()
	{
		return $this->_path->getAppDir();
	}

	/**
	 * Returns the path to the template directory
	 *
	 * @deprecated
	 * @return string
	 */
	public function getTemplateDir()
	{
		return $this->_path->getTemplateDir();
	}

	/**
	 * Returns the path to the public directory
	 *
	 * @deprecated
	 * @return string
	 */
	public function getPublicDir()
	{
		return $this->_path->getPublicDir();
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
	 * Retrieves and stores the config file named $name
	 *
	 * @throws\Exception
	 * @param string $name
	 * @return void
	 */
	public function loadConfig($name)
	{
		$this->_configLoader->load($name);
	}

	/**
	 * Returns the config for $name
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function getConfigs($name)
	{
		return $this->_configLoader->getConfigs($name);
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
		return $this->_configLoader->getConfig($name, $key);
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
