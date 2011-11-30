<?php
namespace Kifs\Partial;

abstract class AbstractPartial
{
	/**
	 * @var string
	 */
	protected $_templateDir;

	/**
	 * @var \Kifs\View\View
	 */
	protected $_view;

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
	 * @param \Kifs\View\View $view
	 */
	public function setView($view)
	{
		$this->_view = $view;
	}

	/**
	 * @param array $params
	 * @return string
	 */
	public function fetch($params)
	{
		$this->_extract($params);

		$this->_render();

		ob_start();
		include $this->_templateDir.'/Partial/'.$this->_getFormatedTemplateName();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * Return the view helper named $name
	 *
	 * @param object $name
	 */
	public function getHelper($name)
	{
		return $this->_view->getHelper($name);
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

		return $templateName.'.php';
	}

	/**
	 * Extract variables from an array and set them as object properties
	 *
	 * @param array $params
	 */
	private function _extract($params)
	{
		foreach ($params as $name => $value) {
			if ('_' !== $name[0] && !is_numeric($name[0]))
				$this->$name = $value;
		}
	}

}