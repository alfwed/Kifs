<?php
namespace Kifs\Application\Generator;

class Generator
{
	private $_appName;

	public function __construct()
	{

	}


	public function generate($appName, $rootDir)
	{
		$this->_appName = $appName;
		$appDir = $rootDir.'/'.$this->_appName;

		// app
		mkdir($appDir.'/'.strtolower($appName));
		mkdir($appDir.'/Config');
		mkdir($appDir.'/Config/Dev');
		mkdir($appDir.'/Config/Prod');
		mkdir($appDir.'/Config/Test');
		// config files
		$this->_genFile($appDir.'Config/Routes.php', 'Config/Routes.php');
		$this->_genFile($appDir.'Config/Dev/Db.php', 'Config/Db.php');
		$this->_genFile($appDir.'Config/Prod/Db.php', 'Config/Db.php');
		$this->_genFile($appDir.'Config/Test/Db.php', 'Config/Db.php');
		mkdir($appDir.'/Controller');
		mkdir($appDir.'/Injector');
		mkdir($appDir.'/Model');
		mkdir($appDir.'/Partial');
		mkdir($appDir.'/Template');
		// error handler templates
		$this->_genFile($appDir.'Template/Error404.php', 'Template/Error404.php');
		$this->_genFile($appDir.'Template/Error500.php', 'Template/Error500.php');

		// public
		mkdir($rootDir.'/public');
		mkdir($rootDir.'/public/css');
		mkdir($rootDir.'/public/js');
		// index file
		$this->_genFile($rootDir.'public/index.php', 'public/index.php');
	}

	private function _genFile($path, $template)
	{
		ob_start();
		require 'Generator/Template/'.template;
		$content = ob_get_contents();
		ob_end_clean();

		file_put_contents($path, $content);
	}
}
