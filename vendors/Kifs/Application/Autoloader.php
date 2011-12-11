<?php
namespace Kifs\Application;

class Autoloader
{
	public function register()
	{
		spl_autoload_register(array('Kifs\Application\Autoloader', 'autoload'));
	}

	public static function autoload($className)
	{
		$path = str_replace('\\', '/', $className).'.php';
		require $path;
	}
}