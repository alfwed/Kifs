<?php

class RouteTest extends PHPUnit_Framework_TestCase
{

	public function testGetUri()
	{
		$route = new Route('foo/bar', '');
		$this->assertEquals('foo/bar', $route->getUri());
	}

	public function testGetUriRemoveTrailingSlash()
	{
		$route = new Route('foo/bar/', '');
		$this->assertEquals('foo/bar', $route->getUri());
	}

	public function testGetUriRemovePrependingSlash()
	{
		$route = new Route('/foo/bar', '');
		$this->assertEquals('foo/bar', $route->getUri());
	}

	public function testGetUriTrimSlashes()
	{
		$route = new Route('/foo/bar/', '');
		$this->assertEquals('foo/bar', $route->getUri());
	}

	public function testGetControllerName()
	{
		$route = new Route('', 'foo');
		$this->assertEquals('foo', $route->getControllerName());
	}

	public function testGetControllerNameReturnsALoweredCaseName()
	{
		$route = new Route('', 'Foo');
		$this->assertEquals('foo', $route->getControllerName());
	}

	public function testGetParams()
	{
		$params = array(':foo' => 'bar');
		$route = new Route('', '', $params);
		$retrievedParams = $route->getParams()
		$this->assertEquals(1, count($retrievedParams));
		$this->assertEquals('bar', $retrievedParams[':foo']);
	}
}
