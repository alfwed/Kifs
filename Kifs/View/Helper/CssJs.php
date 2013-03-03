<?php
namespace Kifs\View\Helper;

class CssJs
{
	const COMMON_FILES_INDEX = '_common';

	private $_config;

	private $_controllerName;


	public function __construct($config, $controllerName)
	{
		$this->_config = $config;
		$this->_controllerName = $controllerName;
	}

	public function getJsArray()
	{
		$js = array();

		if ($this->_indexIsArray(self::COMMON_FILES_INDEX, 'js')) {
			foreach ($this->_config[self::COMMON_FILES_INDEX]['js'] as $jsFile) {
				$js[] = '/js/' . $jsFile;
			}
		}

		if ($this->_indexIsArray($this->_controllerName, 'js')) {
			foreach ($this->_config[$this->_controllerName]['js'] as $jsFile) {
				$js[] = '/js/' . $jsFile;
			}
		}

		return $js;
	}

	public function getCssArray()
	{
		$css = array();

		if ($this->_indexIsArray(self::COMMON_FILES_INDEX, 'css')) {
			foreach ($this->_config[self::COMMON_FILES_INDEX]['css'] as $cssFile) {
				$css[] = '/css/' . $cssFile;
			}
		}

		if ($this->_indexIsArray($this->_controllerName, 'css')) {
			foreach ($this->_config[$this->_controllerName]['css'] as $cssFile) {
				$css[] = '/css/' . $cssFile;
			}
		}

		return $css;
	}

	private function _indexIsArray($controllerName, $key)
	{
		return !empty($this->_config[$controllerName][$key])
				&& is_array($this->_config[$controllerName][$key]);
	}

}
