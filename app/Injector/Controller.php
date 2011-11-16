<?php
namespace Injector;

class Controller
{
	private $_appScope;

	public function __construct($appScope)
	{
		$this->_appScope = $appScope;
	}

	public function injectError404()
	{
		return new \Controller\Error404();
	}

}
