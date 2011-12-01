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

		if ('/' == substr($rootDir, strlen($rootDir)-1))
			$rootDir = substr($rootDir, 0, -1);

		$appDir = $rootDir.'/'.strtolower($appName);

		// App
		$this->_mkdir($appDir);

		// App - Config
		$this->_mkdir($appDir.'/Config');
		$this->_mkdir($appDir.'/Config/Dev');
		$this->_mkdir($appDir.'/Config/Prod');
		$this->_mkdir($appDir.'/Config/Test');
		$this->_genFile($appDir.'/Config/Routes.php', 'Config/Routes.php');
		$this->_genFile($appDir.'/Config/Dev/Db.php', 'Config/Db.php');
		$this->_genFile($appDir.'/Config/Prod/Db.php', 'Config/Db.php');
		$this->_genFile($appDir.'/Config/Test/Db.php', 'Config/Db.php');

		// App - Controller
		$this->_mkdir($appDir.'/Controller');
		$this->_genFile($appDir.'/Controller/Error404.php', 'Controller/Error404.php');

		// App - Injector
		$this->_mkdir($appDir.'/Injector');
		$this->_genFile($appDir.'/Injector/Application', 'Injector/Application.php');
		$this->_genFile($appDir.'/Injector/Business', 'Injector/Business.php');
		$this->_genFile($appDir.'/Injector/Controller', 'Injector/Controller.php');
		$this->_genFile($appDir.'/Injector/Model', 'Injector/Model.php');
		$this->_genFile($appDir.'/Injector/Partial', 'Injector/Partial.php');

		// App - Model
		$this->_mkdir($appDir.'/Model');

		// App - Partial
		$this->_mkdir($appDir.'/Partial');

		// App - Template
		$this->_mkdir($appDir.'/Template');
		$this->_genFile($appDir.'/Template/Error404.php', 'Template/Error404.php');
		$this->_genFile($appDir.'/Template/Error500.php', 'Template/Error500.php');

		// Public
		$this->_mkdir($rootDir.'/public');
		$this->_mkdir($rootDir.'/public/css');
		$this->_mkdir($rootDir.'/public/js');
		$this->_genFile($rootDir.'/public/index.php', 'public/index.php');

		// Data
		$this->_mkdir($rootDir.'/data');

		// Vendors
		$this->_mkdir($rootDir.'/vendors');
	}

	private function _mkdir($path)
	{
		echo 'Creating directory '.$path.' : ';
		$result = mkdir($path);
		echo ($result ? 'OK' : 'KO')."\n";
	}

	private function _genFile($path, $template)
	{
		echo 'Generating file '.$path.' : ';

		ob_start();
		require 'Template/'.$template;
		$content = ob_get_contents();
		ob_end_clean();

		$result = file_put_contents($path, $content);

		echo ($result>0 ? 'OK' : 'KO')."\n";
	}
}
