<?php
namespace Kifs\Partial;

abstract class AbstractPartial
{
	protected $_templateDir;

	protected $_params;


	public function setTemplateDir($dir)
	{
		$this->_templateDir = $dir;
	}

	public function fetch($params)
	{
		$this->_params = $params;

		$this->_render();

		extract($this->_params);

		ob_start();
		include $this->_templateDir.'/Partial/'.$this->_getFormatedTemplateName();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	abstract protected function _render();

	private function _getFormatedTemplateName()
	{
		$names = explode('\\', get_class($this));
		array_shift($names);
		$templateName = implode('\\', $names);

		return $templateName;
	}

}