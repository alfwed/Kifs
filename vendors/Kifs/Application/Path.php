<?php
namespace Kifs\Application;

class Path
{
	/**
	 * Path to the document root directory
	 *
	 * @var string
	 */
	private $_rootDir;

	/**
	 * Path to the application directory
	 *
	 * @var string
	 */
	private $_appDir;

	/**
	 * Path to the public directory
	 *
	 * @var string
	 */
	private $_publicDir;

	/**
	 * Path to the template directory
	 *
	 * @var string
	 */
	private $_tplDir;


	/**
	 * @param string $rootDir
	 */
	public function __construct($rootDir)
	{
		$this->_rootDir = $rootDir;
		$this->_appDir = $this->_rootDir . '/app';
		$this->_publicDir = $this->_rootDir . '/public';
		$this->_tplDir = $this->_appDir . '/Template';
	}

	/**
	 * Returns the path to the document root directory
	 *
	 * @return string
	 */
	public function getRootDir()
	{
		return $this->_rootDir;
	}

	/**
	 * Returns the path to the application directory
	 *
	 * @return string
	 */
	public function getAppDir()
	{
		return $this->_appDir;
	}

	/**
	 * Sets the path to the application directory
	 *
	 * @param string $appDir
	 * @return void
	 */
	public function setAppDir($appDir)
	{
		$this->_appDir = $appDir;
	}

	/**
	 * Returns the path to the template directory
	 *
	 * @return string
	 */
	public function getTemplateDir()
	{
		return $this->_tplDir;
	}

	/**
	 * Sets the path to the template directory
	 *
	 * @param string $tplDir
	 * @return void
	 */
	public function setTemplateDir($tplDir)
	{
		$this->_tplDir = $tplDir;
	}

	/**
	 * Returns the path to the public directory
	 *
	 * @return string
	 */
	public function getPublicDir()
	{
		return $this->_publicDir;
	}

	/**
	 * Sets the path to the public directory
	 *
	 * @param string $dir
	 * @return void
	 */
	public function setPublicDir($dir)
	{
		$this->_publicDir = $dir;
	}
}
