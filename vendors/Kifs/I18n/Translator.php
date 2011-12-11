<?php
namespace Kifs\I18n;

class Translator
{
	/**
	 * Array of translations
	 *
	 * Exemple :
	 * 		array(
	 * 			'Foo' => array('Foo', 'Foos')
	 * 		)
	 *
	 * @var array
	 */
	private $_translations;


	/**
	 * @param array $translations
	 */
	public function __construct($translations)
	{
		$this->_translations = $translations;
	}

	/**
	 * Return the translation corresponding to the given $key key. If no
	 * matching translation is found, it will return the key.
	 *
	 * @param string $country Translation for this country
	 * @param string $lang Translation for this language
	 * @param string $key Key of the translation
	 * @param string $plural Returns plural translation
	 * @return string
	 */
	public function getTranslation($country, $lang, $key, $plural)
	{
		if (!isset($this->_translations[$key]))
			return $this->_noTranslation($key);

		$plural = (int) ((bool)$plural);

		if (isset($this->_translations[$key][$plural]))
			return $this->_translations[$key][$plural];

		if (isset($this->_translations[$key][0]))
			return $this->_translations[$key][0];

		return $this->_noTranslation($key);
	}

	/**
	 * Text to return if no translation was found
	 *
	 * @param string $key
	 * @return string
	 */
	private function _noTranslation($key)
	{
		return '###'.$key.'###';
	}

}
