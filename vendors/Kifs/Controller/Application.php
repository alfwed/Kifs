<?php
namespace Kifs\Controller;

class Application
{
	/**
	 * @var \Kifs\Controller\Router\Standard
	 */
	private $_router;

	/**
	 * @var \Injector\Controller
	 */
	private $_controllerFactory;

	/**
	 * @var \Kifs\Injector\Application
	 */
	private $_appFactory;


	/**
	 * @param \Kifs\Controller\Router\Standard $router
	 * @param \Kifs\Injector\Controller $controllerFactory
	 * @param \Kifs\Injector\Application $appFactory
	 */
	public function __construct($router, $controllerFactory, $appFactory)
	{
		$this->_router = $router;
		$this->_controllerFactory = $controllerFactory;
		$this->_appFactory = $appFactory;
	}

	/**
	 * @param \Kifs\Controller\Request\Http $request
	 * @throws \Exception
	 */
	public function dispatch($request)
	{
		$this->_router->route($request);

		$controllerName = $request->getControllerName();

		try {
			$controller = $this->_controllerFactory->get($controllerName);
		} catch (\Exception $e) {
			if ($request->isDispatched()) {
				throw new \Exception('Controller Error404 does not exists');
			}

			$request->setControllerName('Error404');
			$request->dispatched(true);
			return $this->dispatch($request);
		}

		/* @var $controller \Kifs\Controller\Action */
		$controller->setResponse($this->_appFactory->injectResponse());
		$controller->setView($this->_appFactory->injectView());

		$response = $controller->dispatch($request);
		$response->send();
	}

	/**
	 * Returns the name of the factory method to call to instanciate the
	 * controller named $controllerName
	 *
	 * @param string $controllerName
	 */
	private static function _getControllerInjectorMethod($controllerName)
	{
		return 'inject'.str_replace('\\', '', $controllerName);
	}
}