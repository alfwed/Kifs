<?php
/*
 * This is where all the glue code goes.
 *
 * TODO update templates for the generator
 * TODO logger
 */

error_reporting(E_ALL);

/*
 * Feel free to rename the app directory as you like
 */
$appDir = realpath(__DIR__.'/../app');

// Init autoloader
set_include_path($appDir.PATH_SEPARATOR.
		realpath(__DIR__.'/../vendors').PATH_SEPARATOR.
		get_include_path());

require 'Kifs/Application/Autoloader.php';
Kifs\Application\Autoloader::register();

// Init application scope
$appScope = new Kifs\Application\Scope($_POST, $_GET, $_COOKIE, $_SERVER);
$appScope->setAppDir($appDir);
$appScope->setTemplateDir($appDir.'/Template');
$appScope->setPublicDir(__DIR__);

// Set env
$env = ucfirst(getenv('APP_ENV') ?: 'prod');
$appScope->setEnv($env);

// Set country
$country = getenv('APP_COUNTRY') ?: 'default';
$appScope->setCountry($country);

// Set language
$lang = getenv('APP_LANG') ?: 'default';
$appScope->setLanguage($lang);

// Init injectors
$partialInjector = new Injector\Partial($appScope);
$modelInjector = new Injector\Model($appScope);
$businessInjector = new Injector\Business($appScope);
$appInjector = new Kifs\Injector\Application($appScope, $partialInjector, $businessInjector);
$controllerInjector = new Injector\Controller($appScope, $modelInjector, $businessInjector);

// Init error handler
$errorHandler = $appInjector->injectErrorHanlder();
$errorHandler->start();

// Init database connections
$appScope->loadConfig('Db');
$appScope->addDbConnection('master', $appInjector->injectMysqlDbConnection(
	$appScope->getConfig('Db', 'host'),
	$appScope->getConfig('Db', 'login'),
	$appScope->getConfig('Db', 'pass'),
	$appScope->getConfig('Db', 'db')
));

// Init Router
$router = $appInjector->injectRouter();

// Init app
$app = $appInjector->injectControllerApplication($router, $controllerInjector);

// Run app
$app->dispatch($appInjector->injectRequest());
