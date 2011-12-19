<?php

class StandardTest extends PHPUnit_Framework_TestCase
{
	private $_router;


	public function setUp()
	{
		$this->_router = new \Kifs\Controller\Router\Standard(array());
	}

	public function testDefaultRoutesWithoutSubfolder()
	{
		$request = $this->_getRequest('/default');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEquals('default', $controller);
	}

	public function testDefaultRoutesWithSubfolder()
	{
		$request = $this->_getRequest('/default/foo');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEquals('default\foo', $controller);
	}

	public function testDefaultRouteReturnsADefaultController()
	{
		$request = $this->_getRequest('/');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEquals('index', $controller);
	}

	public function testStaticCustomRouteIsUsedWhenItMatches()
	{
		$route = new \Kifs\Controller\Router\Route('/custom', 'Bar', array());
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/custom');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEquals('bar', $controller);
	}

	public function testStaticCustomRouteIsntUsedWhenItDoesntMatches()
	{
		$route = new \Kifs\Controller\Router\Route('/custom', 'Bar', array());
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/notcustom');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEquals('notcustom', $controller);
	}

	public function testCustomRouteWithIntParameterIsUsedWhenItMatches()
	{
		$route = new \Kifs\Controller\Router\Route('/custom/foo/:num', 'Bar', array(':num'=>'int'));
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/custom/foo/4');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEquals('bar', $controller);
	}

	public function testCustomRouteWithIntParameterIsntUsedWhenItDoesntMatches()
	{
		$route = new \Kifs\Controller\Router\Route('/custom/:num/foo', 'Barnum', array(':num'=>'int'));
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/notcustom');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEquals('notcustom', $controller);
	}

	public function testCustomRouteWithIntParameterIsntUsedWhenParamIsString()
	{
		$route = new \Kifs\Controller\Router\Route('/custom/foo/:num', 'Bar', array(':num'=>'int'));
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/custom/foo/alfwed');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEquals('custom\foo\alfwed', $controller);
	}

	public function testCustomRouteWithStringParameterIsUsedWhenItMatches()
	{
		$route = new \Kifs\Controller\Router\Route('/custom/foo/:word/bar', 'Barstring', array(':word'=>'string'));
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/custom/foo/alfwed/bar');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEquals('barstring', $controller);
	}

	public function testCustomRouteWithStringParameterIsntUsedWhenItDoesntMatches()
	{
		$route = new \Kifs\Controller\Router\Route('/custom/foo/:word/bar/baz', 'Barstring', array(':word'=>'string'));
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/custom/foo/alfwed/bar/ball');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEquals('custom\foo\alfwed\bar\ball', $controller);
	}

	/**
	 * @param string $uri
	 * @return \Kifs\Controller\Request\Http
	 */
	private function _getRequest($uri)
	{
		$server = array(
			'REQUEST_URI' => $uri
		);
		return new \Kifs\Controller\Request\Http(array(), array(), array(), $server);
	}

}