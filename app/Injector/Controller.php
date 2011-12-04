<?php
namespace Injector;

class Controller
{
	/**
	 * @var \Kifs\Application\Scope
	 */
	private $_appScope;

	/**
	 * @var Model
	 */
	private $_modelInjector;

	/**
	 * @var Business
	 */
	private $_businessInjector;

	/**
	 * @param \Kifs\Application\Scope $appScope
	 * @param Model $modelInjector
	 * @param Business $businessInjector
	 */
	public function __construct($appScope, $modelInjector, $businessInjector)
	{
		$this->_appScope = $appScope;
		$this->_modelInjector = $modelInjector;
		$this->_businessInjector = $businessInjector;
	}

	public function injectError404()
	{
		return new \Controller\Error404();
	}

	public function injectIndex()
	{
		return new \Controller\Index();
	}

	public function injectDummy()
	{
		return new \Controller\Dummy($this->_modelInjector->injectDummy());
	}

}
