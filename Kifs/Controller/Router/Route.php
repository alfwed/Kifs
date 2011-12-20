<?php
namespace Kifs\Controller\Router;

class Route
{
	/**
	 * URI of the page
	 *
	 * @var string
	 */
	private $_uri;

	/**
	 * Name of the controller associated with the URI
	 *
	 * @var string
	 */
	private $_controllerName;

	/**
	 * Type of the parameters of the URI
	 *
	 * Exemple :
	 * 		array(':paramname' => 'int')
	 *
	 * Available types are 'int' or 'string'
	 *
	 * @var array
	 */
	private $_params;


	/**
	 * @param string $uri
	 * @param string $controllerName
	 * @param array $params
	 */
	public function __construct($uri, $controllerName, $params = array())
	{
		$this->_uri = $this->_cleanUri($uri);
		$this->_controllerName = $this->_cleanControllerName($controllerName);
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

	private function _cleanUri($uri)
	{
		return trim($uri, '/');
	}

	private function _cleanControllerName($controllerName)
	{
		return strtolower($controllerName);
	}
}
