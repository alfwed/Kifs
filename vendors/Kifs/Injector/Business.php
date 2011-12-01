<?php
namespace Kifs\Injector;

class Business
{
	/**
	 * @var \Kifs\Application\Scope
	 */
	protected $_appScope;


	/**
	 * @param \Kifs\Application\Scope
	 */
	public function __construct($appScope)
	{
		$this->_appScope = $appScope;
	}

	public function injectI18nTranslator()
	{
		// FIXME Load lang file dynamicaly
		$lang = include $this->_appScope->getAppDir().'/Lang/us/en.php';
		return new \Kifs\I18n\Translator('', $lang);
	}

}
