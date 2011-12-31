<?php
namespace Kifs\Controller\Request;

class Http
{
	private $_posts;

	private $_queries;

	private $_cookies;

	private $_server;

	private $_controllerName;

	private $_controllerAction;

	private $_dispatched = false;


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
	 * Get POST variable named $key
	 *
	 * @param string $key
	 */
	public function getPost($key)
	{
		if (isset($this->_posts[$key]))
			return $this->_posts[$key];

		return null;
	}

	/**
	 * Get all POST variables
	 */
	public function getPosts()
	{
		return $this->_posts;
	}

	/**
	 * Get GET variable name $key
	 *
	 * @param string $key
	 */
	public function getQuery($key)
	{
		if (isset($this->_queries[$key]))
			return $this->_queries[$key];

		return null;
	}

	/**
	 * Get all GET variables
	 */
	public function getQueries()
	{
		return $this->_queries;
	}

	/**
	 * Get cookie named $key
	 *
	 * @param string $key
	 */
	public function getCookie($key)
	{
		if (isset($this->_cookies[$key]))
			return $this->_cookies[$key];

		return null;
	}

	/**
	 * Get all cookies
	 */
	public function getCookies()
	{
		return $this->_cookies;
	}

	/**
	 * Get Server variable named $key
	 *
	 * @param string $key
	 */
	public function getServer($key)
	{
		if (isset($this->_server[$key]))
			return $this->_server[$key];

		return null;
	}

	/**
	 * Get all Server variables
	 */
	public function getServers()
	{
		return $this->_server;
	}

	/**
	 * Get the name of the controller that will handle the request
	 */
	public function getControllerName()
	{
		return $this->_controllerName;
	}

	/**
	 * Set the name of the controller that will handle the request
	 *
	 * @param string $controllerName
	 */
	public function setControllerName($controllerName)
	{
		$this->_controllerName = $controllerName;
	}

	/**
	 * Return true if the request has been dispatched and false otherwise.
	 */
	public function isDispatched()
	{
		return $this->_dispatched;
	}

	/**
	 * Set to true if the request has been dispatched and false otherwise
	 *
	 * @param boolean $dispatched
	 */
	public function dispatched($dispatched)
	{
		$this->_dispatched = $dispatched;
	}

	/**
	 * Returns true if the URL was requested by a mobile phone
	 *
	 * @return bool
	 */
	public function fromMobilePhone()
	{
		// FIXME implement fromMobilePhone()
		return false;
	}
}
