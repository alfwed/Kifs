<?php
namespace Kifs\View;

class Standard implements View
{
	private $_engine;

	private $_templateDir;

	private $_helpers;


	public function __construct($viewEngine, $templateDir)
	{
		$this->_engine = $viewEngine;
		$this->_templateDir = $templateDir;
	}

	public function fetch($templateName)
	{
		//return $this->_engine->fetch();

		ob_start();
		require $this->_templateDir.'/'.$templateName.'.php';
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function registerHelper($helper)
	{
		$helperName = get_class($helper);
		$helperName = substr($helperName, strrpos($helperName, '\\')+1);

		$this->_helpers[$helperName] = $helper;
	}

	public function getHelper($name)
	{
		if (isset($this->_helpers[$name]))
			return $this->_helpers[$name];

		return null;
	}

}
