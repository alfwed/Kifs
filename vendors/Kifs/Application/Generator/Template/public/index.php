<?php echo '<?php'; ?>

/*
 * This is where all the glue code goes.
 */

error_reporting(E_ALL);

/*
 * Feel free to rename the app directory as you like
 */
$appDir = realpath(__DIR__.'/../<?php echo $this->_appName; ?>');

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

// Init injectors
$partialInjector = new Injector\Partial($appScope);
$appInjector = new Kifs\Injector\Application($appScope, $partialInjector);
$modelInjector = new Injector\Model($appScope);
$businessInjector = new Injector\Business($appScope);
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