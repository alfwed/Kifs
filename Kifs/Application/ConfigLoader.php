<?php
namespace Kifs\Application;

class ConfigLoader
{
	/**
	 * @var string
	 */
	private $_env;

	/**
	 * @var \Kifs\Application\Path
	 */
	private $_path;

	/**
	 * @var array
	 */
	private $_configs;


	/**
	 * @param string $env
	 * @param \Kifs\Application\Path $path
	 */
	public function __construct($env, $path)
	{
		$this->_env = $env;
		$this->_path = $path;
	}

	/**
	 * Retrieves and stores the config file named $configName
	 *
	 * @throws\Exception If the given config name doesn't match any file
	 * @param string $configName
	 * @return void
	 */
	public function load($configName)
	{
		if (isset($this->_configs[$configName]))
			return;

		// Make this variable visible into the config files
		$path = $this->_path;

		if (file_exists($this->_getEnvFilename($configName)))
			$this->_configs[$configName] = include $this->_getEnvFilename($configName);
		elseif (file_exists($this->_getCommonFilename($configName)))
			$this->_configs[$configName] = include $this->_getCommonFilename($configName);
		else
			throw new \Exception('Config file for "'.$configName.'" does not exist');
	}

	/**
	 * Returns the config for $name
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function getConfigs($name)
	{
		if (isset($this->_configs[$name]))
			return $this->_configs[$name];

		return null;
	}

	/**
	 * Returns the value for the key $key from the config array $name
	 *
	 * @param string $name
	 * @param string $key
	 * @return mixed
	 */
	public function getConfig($name, $key)
	{
		if (isset($this->_configs[$name][$key]))
			return $this->_configs[$name][$key];

		return null;
	}

	/**
	 * Returns the path to the config file common to all environments
	 *
	 * @param string $name
	 */
	protected function _getCommonFilename($name)
	{
		return $this->_path->getAppDir().'/Config/'.$name.'.php';
	}

	/**
	 * Returns the path to config file for the current environment
	 *
	 * @param string $name
	 */
	protected function _getEnvFilename($name)
	{
		return $this->_path->getAppDir().'/Config/'.$this->_env.'/'.$name.'.php';
	}

}
