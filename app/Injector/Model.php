<?php
namespace Injector;

class Model
{
	/**
	 * @var \Kifs\Application\Scope
	 */
	private $_appScope;


	/**
	 * @param \Kifs\Application\Scope $appScope
	 */
	public function __construct($appScope)
	{
		$this->_appScope = $appScope;
	}

	public function injectDummy()
	{
		return new \Model\Dummy($this->_appScope->getDbConnection('master'));
	}
}
