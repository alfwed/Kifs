<?php
namespace Kifs\View\Helper;

class Url
{
	/**
	 * Contains all the custom routes of the application
	 * Array of \Kifs\Controller\Router\Route
	 *
	 * @var array
	 */
	private $_routes;

	/**
	 * Root url of the website
	 *
	 * @var string
	 */
	private $_rootUrl;

	/**
	 * Stores the URL mapping to a controller for faster access
	 *
	 * @var array
	 */
	private $_cachedRoutes = array();


	/**
	 * @param array $routes
	 */
	public function __construct($routes, $rootUrl)
	{
		$this->_routes = $routes;
		$this->_rootUrl = $rootUrl;
	}

	/**
	 * Returns the URL mapping to the controller $controller
	 *
	 * @param string $controller
	 * @param array $params
	 */
	public function getUrl($controller, $params = array())
	{
		if (empty($params) && isset($this->_cachedRoutes[$controller]))
			return $this->_cachedRoutes[$controller];

		foreach ($this->_routes as $route) {
			/* @var $route \Kifs\Controller\Router\Route */
			if ($route->getControllerName() == $controller) {
				$uri = $route->getUri();
				if (empty($params)) {
					$this->_cachedRoutes[$controller] = $uri;
				} else {
					$binds = array_map(function($v){
								return '#'.$v.'#';}, array_keys($params));
					$values = array_values($params);
					$uri = preg_replace($binds, $values, $uri);
				}

				return $this->_rootUrl.$uri;
			}
		}

		return $this->_rootUrl.$controller;
	}

}
