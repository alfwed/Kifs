<?php
namespace Kifs\Injector;

class Application
{
	/**
	 * @var \Kifs\Application\Scope
	 */
	protected $_appScope;

	/**
	 * @var \Kifs\Injector\Partial
	 */
	protected $_partialInjector;

	/**
	 * @var \Kifs\Injector\Business
	 */
	protected $_businessInjector;


	/**
	 * @param \Kifs\Application\Scope $appScope
	 * @param \Kifs\Injector\Partial $partialInjector
	 * @param \Kifs\Injector\Business
	 */
	public function __construct($appScope, $partialInjector, $businessInjector)
	{
		$this->_appScope = $appScope;
		$this->_partialInjector = $partialInjector;
		$this->_businessInjector = $businessInjector;
	}

	public function injectConfigLoader()
	{
		return new \Kifs\Application\ConfigLoader(
			$this->_appScope->getEnv(),
			$this->_appScope->getPath()
		);
	}

	public function injectPath($rootDir)
	{
		return new \Kifs\Application\Path($rootDir);
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
		if (null === $this->_appScope->getInstance('Response'))
			$this->_appScope->registerInstance(
				'Response',
				new \Kifs\Controller\Response\Http()
			);

		return $this->_appScope->getInstance('Response');
	}

	public function injectMysqlDbConnection($dbName)
	{
		$this->_appScope->loadConfig('Db');
		$dbConf = $this->_appScope->getConfig('Db', $dbName);

		if (is_null($dbConf))
			throw new \Exception('Unable to load config for Db:'.$dbName.'. Config doesn\'t exist.');

		$con = new \Kifs\Db\MysqlPDO();
		$con->connect(
			$dbConf['host'],
			$dbConf['login'],
			$dbConf['pass'],
			$dbConf['db']
		);
		return $con;
	}

	public function injectView() // FIXME pass a scope object to allow customization
	{
		$view = new \Kifs\View\Standard(
			$this->_appScope->getPath()->getTemplateDir(),
			$this->_partialInjector,
			$this->injectCache('View')
		);
		$view->registerHelper($this->injectViewHelperCssJs());
		$view->registerHelper($this->injectViewHelperUrl());
		$view->registerHelper($this->injectViewHelperTranslation());
		return $view;
	}

	public function injectViewHelperCssJs()
	{
		try {
			$this->_appScope->loadConfig('CssJs');
			$conf = $this->_appScope->getConfigs('CssJs');
		} catch (\Exception $e) {
			$conf = array();
		}

		return new \Kifs\View\Helper\CssJs($conf);
	}

	public function injectViewHelperUrl()
	{
		$this->_appScope->loadConfig('Routes');
		$this->_appScope->loadConfig('Url');

		$rootUrl = $this->_appScope->getConfig('Url', $this->_appScope->getCountry());

		if (null === $rootUrl) {
			$rootUrl = $this->_appScope->getConfig('Url', 'default');
		}

		return new \Kifs\View\Helper\Url(
			$this->_appScope->getConfigs('Routes'),
			$rootUrl
		);
	}

	public function injectViewHelperTranslation()
	{
		return new \Kifs\View\Helper\Translation(
			$this->_businessInjector->injectI18nTranslator(),
			$this->_appScope->getCountry(),
			$this->_appScope->getLanguage()
		);
	}

	/**
	 * This method should be override for customization
	 *
	 * @param string $requester
	 */
	public function injectCache($requester)
	{
		switch ($requester) {
			case 'View':
				return $this->injectCacheFile();
			default:
				return $this->injectCacheFile();
		}
	}

	public function injectCacheFile()
	{
		return new \Kifs\Cache\File($this->_appScope->getPath()->getCacheDir());
	}

}
