<?php

class TranslatorTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var \Kifs\I18n\Translator
	 */
	private $_translator;

	public function setup()
	{
		$trads = array(
			'foo' => array('foo', 'foos'),
			'bar' => array('bar')
		);

		$this->_translator = new \Kifs\I18n\Translator($trads);
	}

	public function testGetTranslationWhenKeyDoesntExists()
	{
		$this->assertEquals('###notfound###', $this->_translator->getTranslation('notfound', 0));
		$this->assertEquals('###notfound###', $this->_translator->getTranslation('notfound', 1));
		$this->assertEquals('###notfound###', $this->_translator->getTranslation('notfound', 2));
	}

	public function testGetTranslationWhenSingularTransExists()
	{
		$this->assertEquals('bar', $this->_translator->getTranslation('bar', 0));
		$this->assertEquals('bar', $this->_translator->getTranslation('bar', 1));
		$this->assertEquals('###bar###', $this->_translator->getTranslation('bar', 2));
	}

	public function testGetTranslationWhenPluralTransExists()
	{
		$this->assertEquals('foo', $this->_translator->getTranslation('foo', 0));
		$this->assertEquals('foo', $this->_translator->getTranslation('foo', 1));
		$this->assertEquals('foos', $this->_translator->getTranslation('foo', 2));
		$this->assertEquals('foos', $this->_translator->getTranslation('foo', 42));
	}
}
