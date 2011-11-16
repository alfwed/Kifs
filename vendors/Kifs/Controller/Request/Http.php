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


	public function __construct($posts, $queries, $cookies, $server)
	{
		$this->_posts = $posts;
		$this->_queries = $queries;
		$this->_cookies = $cookies;
		$this->_server = $server;
	}

	public function getPost($key)
	{
		if (isset($this->_posts[$key]))
			return $this->_posts[$key];

		return null;
	}

	public function getPosts()
	{
		return $this->_posts;
	}

	public function getQuery($key)
	{
		if (isset($this->_queries[$key]))
			return $this->_queries[$key];

		return null;
	}

	public function getQueries()
	{
		return $this->_queries;
	}

	public function getCookie($key)
	{
		if (isset($this->_cookies[$key]))
			return $this->_cookies[$key];

		return null;
	}

	public function getCookies()
	{
		return $this->_cookies;
	}

	public function getServers()
	{
		return $this->_server;
	}

	public function getServer($key)
	{
		if (isset($this->_server[$key]))
			return $this->_server[$key];

		return null;
	}

	public function getControllerName()
	{
		return $this->_controllerName;
	}

	public function setControllerName($controllerName)
	{
		$this->_controllerName = $controllerName;
	}

	public function isDispatched()
	{
		return $this->_dispatched;
	}

	public function dispatched($dispatched)
	{
		$this->_dispatched = $dispatched;
	}
}
