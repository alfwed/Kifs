<?php
namespace Kifs\Controller\Router;

class Standard
{
	/**
	 *Array of routes
	 *
	 *	array(
	 *		uri => /plop/foo/:page/bar
	 *		controllerName => Foo\Bar
	 * 		params => array(':paramname' => 'int')
	 * 	)
	 *
	 * @var array
	 */
	private $_routes;


	/**
	 * @param array $config array of Route
	 */
	public function __construct($config)
	{
		$this->_loadRoutesFromConfig($config);
	}

	/**
	 * Add a route to a controller
	 *
	 * @param Route $route
	 * @return void
	 */
	public function addRoute($route)
	{
		$this->_routes[] = array(
			'uri' => $route->getUri(),
			'controller' => $route->getControllerName(),
			'params' => $route->getParams()
		);
	}

	/**
	 * @param \Kifs\Controller\Request\Http $request
	 * @return bool
	 */
	public function route($request)
	{
		if ($this->_requestAlreadyRouted($request))
			return false;

		$uri = $request->getServer('REQUEST_URI');
		$uri = strtolower(substr($uri, 1));

		if (!empty($this->_routes)) {
			$this->_createUriPatterns($uri);

			foreach ($this->_routes as $route) {
				if (preg_match($route['uriPattern'], $uri)) {
					$request->setControllerName($route['controller']);
					return true;
				}
			}
		}

		// Use default route if no user defined routes matched the URI
		$request->setControllerName($this->_getDefaultRoute($uri));
		return true;
	}

	/**
	 * Retrieve router's configuration from the $config array
	 *
	 * @param array $config
	 */
	private function _loadRoutesFromConfig($config)
	{
		foreach ($config as $route) {
			/* @var $route \Kifs\Controller\Router\Route */
			$this->addRoute($route);
		}
	}

	/**
	 * Check if the request $request has already been routed
	 *
	 * @param \Kifs\Controller\Request\Http $request
	 */
	private function _requestAlreadyRouted($request)
	{
		$controllerName = $request->getControllerName();
		if (empty($controllerName))
			return false;

		return true;
	}

	/**
	 * Create regexp patterns for all the known routes
	 */
	private function _createUriPatterns()
	{
		foreach ($this->_routes as &$route) {
			$patterns = array();
			$route['uriPattern'] = '#^';

			if (!empty($route['params'])) {
				foreach ($route['params'] as $name => $type) {
					$params[] = '#'.$name.'#';
					switch ($type) {
						case 'int':
							$patterns[] = '\d+';
							break;
						case 'string':
							$patterns[] = '[^/]+';
							break;
						default:
							throw Exception('Unknow parameter type');
					}
				}

				$route['uriPattern'] .= preg_replace($params, $patterns, $route['uri']);
			} else {
				$route['uriPattern'] .= $route['uri'];
			}
			$route['uriPattern'] .= '#';
		}
	}

	/**
	 * Return the controller to call if the uri doesn't match any rule
	 *
	 * @param string $uri
	 */
	private function _getDefaultRoute($uri)
	{
		if (empty($uri))
			return 'index';

		return str_replace('/', '\\', $uri);
	}

}
