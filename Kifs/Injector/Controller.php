<?php
namespace Kifs\Injector;

class Controller
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

	public function get($controllerName)
	{
		$method = self::_getInjectorMethod($controllerName);
		if (method_exists($this, $method)) {
			$controller = $this->$method();
			return $controller;
		}

		throw new \Exception('Injector for the controller '.$controllerName.' doesn\'t exist');
	}

	/**
	 * Return the name of factory method which instanciates the controller
	 * named $controllerName
	 *
	 * @param string $name
	 */
	protected static function _getInjectorMethod($controllerName)
	{
		return 'inject'.str_replace('\\', '', $controllerName);
	}

}
