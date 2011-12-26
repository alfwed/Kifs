<?php
namespace Kifs\View\Helper;

class Translation
{
	/**
	 * @var \Kifs\I18n\Translator
	 */
	private $_translator;


	/**
	 * @param \Kifs\I18n\Translator $translator
	 */
	public function __construct($translator)
	{
		$this->_translator = $translator;
	}

	public function tr($key, $plural = 0)
	{
		return $this->_getTranslation($key, $plural);
	}

	private function _getTranslation($key, $plural)
	{
		return $this->_translator->getTranslation(
			$key,
			$plural
		);
	}

}
