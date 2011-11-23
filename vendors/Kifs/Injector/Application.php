<?php
namespace Kifs\Injector;

class Application
{
	/**
	 * @var \Kifs\Application\Scope
	 */
	private $_appScope;


	/**
	 * @param \Kifs\Application\Scope $appScope
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
		$this->_appScope->loadConfig('Routes');
		return new \Kifs\Controller\Router\Standard($this->_appScope->getConfigs('Routes'));
	}

	public function injectRequest()
	{
		return new \Kifs\Controller\Request\Http(
			$this->_appScope->getPosts(),
			$this->_appScope->getQueries(),
			$this->_appScope->getCookies(),
			$this->_appScope->getServer()
		);
	}

	public function injectResponse()
	{
		return new \Kifs\Controller\Response\Http();
	}

	public function injectMysqlDbConnection($host, $login, $pass, $db)
	{
		$con = new \Kifs\Db\MysqlPDO();
		$con->connect($host, $login, $pass, $db);
		return $con;
	}

	public function injectView() // FIXME pass a scope object to allow customization
	{
		$view = new \Kifs\View\Standard(null, $this->_appScope->getTemplateDir()); //FIXME Engine or not?
		$view->registerHelper($this->injectViewHelperCssJs());
		return $view;
	}

	public function injectViewHelperCssJs()
	{
		$this->_appScope->loadConfig('View/Helper/CssJs');
		return new \Kifs\View\Helper\CssJs(
			$this->_appScope->getConfigs('View/Helper/CssJs'),
			$this->_appScope->getPublicDir()
		);
	}

}
