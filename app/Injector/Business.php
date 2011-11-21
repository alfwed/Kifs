<?php
namespace Injector;

class Business
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

}
