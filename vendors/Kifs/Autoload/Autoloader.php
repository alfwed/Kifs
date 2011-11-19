<?php
namespace Kifs\Autoload;

class Autoloader // FIXME move to Application\Autoloader
{
	public function register()
	{
		spl_autoload_register(array('Kifs\Autoload\Autoloader', 'autoload'));
	}

	public static function autoload($className)
	{
		$path = str_replace('\\', '/', $className).'.php';
		require $path;
	}
}