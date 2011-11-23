<?php
namespace Kifs\View;

class Standard implements View
{
	private $_engine;

	private $_templateDir;

	private $_partialDir;

	private $_partialFactory;

	private $_helpers = array();


	public function __construct($viewEngine, $templateDir, $partialFactory)
	{
		$this->_engine = $viewEngine;
		$this->_templateDir = $templateDir;
		$this->_partialDir = $templateDir.'/Partial';
		$this->_partialFactory = $partialFactory;
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

	/**
	 * Output the content of a partial.
	 *
	 * @param string $name
	 * @param array $params
	 * @return void
	 */
	public function partial($name, $params = array())
	{
		if (null !== $partial = $this->_partialFactory->get($name)) {
			echo $partial->fetch($params);
			return;
		}

		if (file_exists($this->_templateDir.'/Partial/'.$name.'.php')) {
			extract($params);
			include $this->_templateDir.'/Partial/'.$name.'.php';
			return;
		}

		throw new Exception('Unable to find partial "'.$name.'"');
	}

}
