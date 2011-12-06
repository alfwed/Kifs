<?php
namespace Kifs\View\Helper;

class CssJs
{
	private $_config;

	private $_publicDir;


	public function __construct($config, $publicDir)
	{
		$this->_config = $config;
		$this->_publicDir = $publicDir;
	}

	public function getJsArray($controllerName)
	{
		$js = array();

		if (!$this->_indexIsArray($controllerName, 'js'))
			return $js;

		foreach ($this->_config[$controllerName]['js'] as $jsFile) {
			$js[] = $this->_publicDir . '/' . $jsFile;
		}

		return $js;
	}

	public function getCssArray($controllerName)
	{
		$css = array();

		if (!$this->_indexIsArray($controllerName, 'css'))
			return $css;

		foreach ($this->_config[$controllerName]['css'] as $cssFile) {
			$css[] = $this->_publicDir . '/' . $cssFile;
		}

		return $css;
	}

	private function _indexIsArray($controllerName, $key)
	{
		return !empty($this->_config[$controllerName][$key])
				&& is_array($this->_config[$controllerName][$key]);
	}

}