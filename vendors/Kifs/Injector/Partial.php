<?php
namespace Kifs\Injector;

abstract class Partial
{
	/**
	 * @var \Kifs\Application\Scope
	 */
	protected $_appScope;


	/**
	 * @param \Kifs\Application\Scope $appScope
	 */
	public function __construct($appScope)
	{
		$this->_appScope = $appScope;
	}

	/**
	 * Return the partial name $name if it exists and null otherwise
	 *
	 * @param string $name
	 */
	public function get($name)
	{
		$method = self::_getInjectorMethod($name);
		if (method_exists($this, $method)) {
			$partial = $this->$method();
			$partial->setTemplateDir($this->_appScope->getTemplateDir());
			return $partial;
		}

		return null;
	}

	/**
	 * Return the name of factory method which instanciates the partial
	 * named $name
	 *
	 * @param string $name
	 */
	protected static function _getInjectorMethod($name)
	{
		return 'inject'.$name;
	}

}
