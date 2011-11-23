<?php
namespace Kifs\Injector;

abstract class Partial
{
	/**
	 * @var \Kifs\Application\Scope
	 */
	protected $_appScope;


	public function __construct($appScope)
	{
		$this->_appScope = $appScope;
	}

	public function get($name)
	{
		$method = $this->_getInjectorMethod($name);
		if (method_exists($this, $method)) {
			$partial = $this->$method();
			$partial->setTemplateDir($this->_appScope->getTemplateDir());
			return $partial;
		}

		return null;
	}

	public function _getInjectorMethod($name)
	{
		return 'inject'.$name;
	}

}
