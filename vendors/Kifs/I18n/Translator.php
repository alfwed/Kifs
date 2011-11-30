<?php
namespace Kifs\I18n;

class Translator
{
	private $_appDir;

	private $_translations;


	public function __construct($appDir, $translations)
	{
		$this->_appDir = $appDir;
		$this->_translations = $translations;
	}

	public function getTranslation($country, $lang, $key, $plural)
	{
		if (!isset($this->_translations[$key]))
			return $this->_noTranslation($key);

		$plural = (int) ((bool)$plural);

		if (isset($this->_translations[$key][$plural]))
			return $this->_translations[$key][$plural];

		if (!isset($this->_translations[$key][0]))
			return $this->_noTranslation($key);
		else
			return $this->_translations[$key][0];

	}

	private function _noTranslation($key)
	{
		return '*** '.$key.' ***';
	}

}
