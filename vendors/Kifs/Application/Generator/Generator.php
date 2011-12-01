<?php
namespace Kifs\Application\Generator;

class Generator
{

	public function __construct()
	{
	}

	public function generate($appName, $rootDir)
	{
		$appDir = $rootDir.'/'.$this->_appName;

		// App
		mkdir($appDir.'/'.strtolower($appName));

		// App - Config
		mkdir($appDir.'/Config');
		mkdir($appDir.'/Config/Dev');
		mkdir($appDir.'/Config/Prod');
		mkdir($appDir.'/Config/Test');
		$this->_genFile($appDir.'Config/Routes.php', 'Config/Routes.php');
		$this->_genFile($appDir.'Config/Dev/Db.php', 'Config/Db.php');
		$this->_genFile($appDir.'Config/Prod/Db.php', 'Config/Db.php');
		$this->_genFile($appDir.'Config/Test/Db.php', 'Config/Db.php');

		// App - Controller
		mkdir($appDir.'/Controller');
		$this->_genFile($appDir.'Controller/Error404.php', 'Controller/Error404.php');

		// App - Injector
		mkdir($appDir.'/Injector');
		$this->_genFile($appDir.'Injector/Application', 'Injector/Application.php');
		$this->_genFile($appDir.'Injector/Business', 'Injector/Business.php');
		$this->_genFile($appDir.'Injector/Controller', 'Injector/Controller.php');
		$this->_genFile($appDir.'Injector/Model', 'Injector/Model.php');
		$this->_genFile($appDir.'Injector/Partial', 'Injector/Partial.php');

		// App - Model
		mkdir($appDir.'/Model');

		// App - Partial
		mkdir($appDir.'/Partial');

		// App - Template
		mkdir($appDir.'/Template');
		$this->_genFile($appDir.'Template/Error404.php', 'Template/Error404.php');
		$this->_genFile($appDir.'Template/Error500.php', 'Template/Error500.php');

		// Public
		mkdir($rootDir.'/public');
		mkdir($rootDir.'/public/css');
		mkdir($rootDir.'/public/js');
		$this->_genFile($rootDir.'public/index.php', 'public/index.php');

		// Data
		mkdir($rootDir.'/data');

		// Vendors
		mkdir($rootDir.'/vendors');
	}

	private function _genFile($path, $template)
	{
		ob_start();
		require 'Template/'.template;
		$content = ob_get_contents();
		ob_end_clean();

		file_put_contents($path, $content);
	}
}
