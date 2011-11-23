<?php
namespace Kifs\Controller\Router;

class Route
{
	private $_uri;

	private $_controllerName;

	private $_params;


	public function __construct($uri, $controllerName, $params)
	{
		$this->_uri = $uri;
		$this->_controllerName = $controllerName;
		$this->_params = $params;
	}

	public function getUri()
	{
		return $this->_uri;
	}

	public function getControllerName()
	{
		return $this->_controllerName;
	}

	public function getParams()
	{
		return $this->_params;
	}

}
