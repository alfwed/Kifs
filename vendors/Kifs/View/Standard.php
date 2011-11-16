<?php
namespace Kifs\View;

class Standard implements View
{
	private $_engine;

	private $_templateDir;


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

}
