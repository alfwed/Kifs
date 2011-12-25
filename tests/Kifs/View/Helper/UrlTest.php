<?php

use \Kifs\Controller\Router\Route;

class UrlTest extends PHPUnit_Framework_TestCase
{
	private $_url;


	public function setUp()
	{
		$rootUrl = 'http://localhost';
		$conf = array(
			new Route('/foo', 'Bar', array()),
			new Route('/foo/:num', 'Baz', array(':num' => 'int')),
		);

		$this->_url = new \Kifs\View\Helper\Url($conf, $rootUrl);
	}

	public function testGetUrlRoot()
	{
		$this->assertEquals('http://localhost', $this->_url->getUrl(''));
	}

	public function testGetUrlForDefaultRoute()
	{
		$this->assertEquals('http://localhost/default', $this->_url->getUrl('default'));
	}

	public function testGetUrlForDefaultRouteWithSubDirectory()
	{
		$this->assertEquals('http://localhost/dir/default', $this->_url->getUrl('dir\default'));
	}

	public function testGetUrlForDefaultRouteWithSubDirectory()
	{
		$this->assertEquals('http://localhost/dir/default', $this->_url->getUrl('dir\default'));
	}

	public function testGetUrlForCustomRoute()
	{
		$this->assertEquals('http://localhost/bar', $this->_url->getUrl('foo'));
	}

	public function testGetUrlForCustomRouteWithParameters()
	{
		$this->assertEquals('http://localhost/foo/2', $this->_url->getUrl('baz', array(':num' => 2)));
	}

}
