<?php
namespace Kifs\View\Helper;

class Translation
{
	/**
	 * @var \Kifs\I18n\Translator
	 */
	private $_translator;

	/**
	 * @var string
	 */
	private $_country;

	/**
	 * @var string
	 */
	private $_language;


	/**
	 * @param \Kifs\I18n\Translator $translator
	 */
	public function __construct($translator, $country, $language)
	{
		$this->_translator = $translator;
		$this->_country = $country;
		$this->_language = $language;
	}

	public function tr($key, $plural = 0, $country = null, $language = null)
	{
		$country = is_null($country) ? $this->_country : $country;
		$language = is_null($language) ? $this->_language : $language;

		return $this->_getTranslation($country, $language, $key, $plural);
	}

	private function _getTranslation($country, $language, $key, $plural = 0)
	{
		return $this->_translator->getTranslation(
			$this->_country,
			$this->_language,
			$key,
			$plural
		);
	}

}
