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
		$lang = include $this->_appScope->getPath()->getAppDir().'/Lang/'.
					$this->_appScope->getCountry().'/'.
					$this->_appScope->getLanguage().'.php';
		return new \Kifs\I18n\Translator($lang);
	}

}
