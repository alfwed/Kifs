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
	 * @param string $key Key of the translation
	 * @param int $plural Returns plural translation
	 * @return string
	 */
	public function getTranslation($key, $plural)
	{
		if (!isset($this->_translations[$key]))
			return $this->_noTranslation($key);

		$plural = $this->_getPluralKey($plural);

		if (isset($this->_translations[$key][$plural]))
			return $this->_translations[$key][$plural];

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

	private function _getPluralKey($plural)
	{
		if (0 < $plural)
			$plural--;

		return (int) ((bool)$plural);
	}

}
