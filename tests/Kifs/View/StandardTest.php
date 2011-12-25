<?php
namespace Kifs\View;

class StandardTest extends PHPUnit_Framework_TestCase
{
	private $view;

	public function setup()
	{
		$partialMock = new \mock\Injector\PartialMock();
		$cache = new \Kifs\Cache\File(TEST_DIR.'/cache');

		$this->view = new Standard(TEST_DIR.'/template', $partialMock, $cache);
	}

	public function testFetch()
	{
		$content = $this->view->fetch('Dummy');
		$this->assertEquals('Content of dummy template', $content);
	}

	public function testPartial()
	{
		ob_start();
		$this->view->partial('Dummy', array('param' => 'foo'));
		$contentTpl = ob_get_contents();
		ob_end_clean();
		$this->assertEquals('Content of dummy partial foo', $contentTpl);

		ob_start();
		$this->view->partial('Mock', array('param' => 'bar'));
		$contentPartial = ob_get_contents();
		ob_end_clean();
		$this->assertEquals('Content of mock partial bar', $contentTpl);
	}

	public function testStartCache()
	{
		// FIXME
	}

	public function testEndCache()
	{
		// FIXME
	}
}
