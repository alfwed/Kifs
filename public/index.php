<?php
/*
 * This is where all the glue code goes. If you like magic tricks, put them here.
 *
 * TODO update templates for the generator - controller/partial
 *
 * TODO logger
 * TODO benchmark
 * TODO create exception classes
 * TODO HTML trimer
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

// Set Path
$appScope->setPath($appInjector->injectPath(realpath(__DIR__.'/..')));

// Set ConfigLoader
$appScope->setConfigLoader($appInjector->injectConfigLoader());

// Init error handler
$errorHandler = $appInjector->injectErrorHanlder();
$errorHandler->start();

// Init database connections
$appScope->addDbConnection('master', $appInjector->injectMysqlDbConnection('master'));

// Init Router
$router = $appInjector->injectRouter();

// Init app
$app = $appInjector->injectControllerApplication($router, $controllerInjector);

// Run app
$app->dispatch($appInjector->injectRequest());
