<?php
namespace Kifs\View\Engine;

class Standard
{
	private $_templateDir;

	public function __construct($templateDir)
	{
		$this->_templateDir = $templateDir;
	}

	public function fetch($templateName)
	{
		ob_start();
		require $this->_templateDir.'/'.$templateName;
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

}
