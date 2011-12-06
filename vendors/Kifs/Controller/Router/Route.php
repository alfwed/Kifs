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
