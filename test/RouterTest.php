<?php

class RouterTest
{
	private $_router;


	public function setUp()
	{
		$this->_router = new \Kifs\Controller\Router\Standard(array());
	}

	public function testDefaultRoutesWithoutSubfolder()
	{
		$request = $this->_getRequest('/foo');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEqual($controller, 'Foo');
	}

	public function testDefaultRoutesWithSubfolder()
	{
		$request = $this->_getRequest('/foo/bar');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEqual($controller, 'Foo\Bar');
	}

	public function testDefaultRouteReturnsADefaultController()
	{
		$request = $this->_getRequest('/');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEqual($controller, 'Index');
	}

	public function testStaticCustomRouteIsUsedWhenItMatches()
	{
		$route = new \Kifs\Controller\Router\Route('/foo', 'Bar', array());
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/foo');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEqual($controller, 'Bar');
	}

	public function testStaticCustomRouteIsntUsedWhenItDoesntMatches()
	{
		$route = new \Kifs\Controller\Router\Route('/foo', 'Bar', array());
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/notcustom');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEqual($controller, 'Notcustom');
	}

	public function testParameterizedCustomRouteIsUsedWhenItMatches()
	{
		$route = new \Kifs\Controller\Router\Route('/foo/bar/:num', 'Bar', array(':num'=>'int'))
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/foo/bar/4');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEqual($controller, 'Bar');
	}

	public function testParameterizedCustomRouteIsntUsedWhenItDoesntMatches()
	{
		$route = new \Kifs\Controller\Router\Route('/foo/:num/bar', 'Barnum', array(':num'=>'int'));
		$this->_router->addRoute($route);

		$request = $this->_getRequest('/notcustom');
		$this->_router->route($request);
		$controller = $request->getControllerName();

		$this->assertEqual($controller, 'Notcustom');
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