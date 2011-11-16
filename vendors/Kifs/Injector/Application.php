<?php
namespace Kifs\Injector;

class Application
{
	/**
	 * @var Kifs\Application\Scope
	 */
	private $_appScope;


	/**
	 * @param Kifs\Application\Scope $appScope
	 */
	public function __construct($appScope)
	{
		$this->_appScope = $appScope;
	}

	public function injectErrorHanlder()
	{
		$this->_appScope->loadConfig('ErrorHandler');
		return new \Kifs\Application\ErrorHandler($this->_appScope->getConfigs('ErrorHandler'));
	}

	public function injectControllerApplication($router, $controllerInjector)
	{
		return new \Kifs\Controller\Application($router, $controllerInjector, $this);
	}

	public function injectRouter()
	{
		return new \Kifs\Controller\Router\Standard();
	}

	public function injectRequest()
	{
		// FIXME Request type
		return new \Kifs\Controller\Request\Http(
			$this->_appScope->getPosts(),
			$this->_appScope->getQueries(),
			$this->_appScope->getCookies(),
			$this->_appScope->getServer()
		);
	}

	public function injectResponse()
	{
		return new \Kifs\Controller\Response\Http(); // FIXME response type
	}

	public function injectView()
	{
		return new \Kifs\View\Standard(null, $this->_appScope->getAppDir().'/Template'); //FIXME Engine or not?
	}

	public function injectMysqlDbConnection($host, $login, $pass, $db)
	{
		$con = new \Kifs\Db\MysqlPDO();
		$con->connect($host, $login, $pass, $db); // FIXME connect or not?
		return $con;
	}

}
