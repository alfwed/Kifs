<?php
namespace Kifs\Partial;

abstract class AbstractPartial
{
	/**
	 * @var string
	 */
	protected $_templateDir;

	/**
	 * @var array
	 */
	protected $_params;


	/**
	 * @param string $dir
	 * @return void
	 */
	public function setTemplateDir($dir)
	{
		$this->_templateDir = $dir;
	}

	/**
	 * @param array $params
	 * @return string
	 */
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

	/**
	 * Core of the partial. This is where you do whatever you have to do
	 *
	 * @return void
	 */
	abstract protected function _render(); // FIXME find name for _render()

	/**
	 * Returns the name of the template corresponding to this controller
	 *
	 * @return string
	 */
	private function _getFormatedTemplateName()
	{
		$names = explode('\\', get_class($this));
		array_shift($names);
		$templateName = implode('\\', $names);

		return $templateName;
	}

}