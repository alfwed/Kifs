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
	 * Return the partial named $name if it exists and null otherwise
	 *
	 * @param string $name
	 * @param \Kifs\View\View $view
	 */
	public function get($name, $view)
	{
		$method = self::_getInjectorMethod($name);
		if (method_exists($this, $method)) {
			$partial = $this->$method();
			return $this->_setPartialDependencies($partial, $view);
		}

		$partial = $this->injectStandard($name);
		return $this->_setPartialDependencies($partial, $view);
	}

	/**
	 * Create a standard partial object
	 *
	 * @param string $name
	 */
	public function injectStandard($name)
	{
		$partial = new \Kifs\Partial\Standard();
		$partial->setTemplateName($name);
		return $partial;
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

	/**
	 * @param \Kifs\Partial\AbstractPartial $partial
	 * @param \Kifs\View\View $view
	 */
	protected function _setPartialDependencies($partial, $view)
	{
		$partial->setTemplateDir($this->_appScope->getPath()->getTemplateDir());
		$partial->setView($view);
		$partial->setResponse($this->_appScope->getInstance('Response'));
		return $partial;
	}
}
