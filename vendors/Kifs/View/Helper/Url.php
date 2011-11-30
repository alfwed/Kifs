<?php
namespace Kifs\View\Helper;

class Url
{
	private $_routes;

	private $_cachedRoutes = array();


	public function __construct($routes)
	{
		$this->_routes = $routes;
	}

	public function getUrl($controller, $params = array())
	{
		// TODO improve caching
		if (empty($params) && isset($this->_cachedRoutes[$controller]))
			return $this->_cachedRoutes[$controller];

		foreach ($this->_routes as $route) {
			/* @var $route \Kifs\Controller\Router\Route */
			if ($route->getControllerName() == $controller) {
				$uri = $route->getUri();
				if (empty($params)) {
					$this->_cachedRoutes[$controller] = $uri;
				} else {
					$binds = array_keys($params);
					$values = array_values($params);
					$uri = preg_replace($uri, $binds, $values);
				}

				return $uri;
			}
		}

		return $controller;
	}

}
