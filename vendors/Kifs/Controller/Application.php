<?php
namespace Kifs\Controller;

class Application
{
	/**
	 * @var \Kifs\Controller\Router\Standard
	 */
	private $_router;

	private $_controllerFactory;

	private $_appFactory;


	public function __construct($router, $controllerFactory, $appFactory)
	{
		$this->_router = $router;
		$this->_controllerFactory = $controllerFactory;
		$this->_appFactory = $appFactory;
	}

	public function dispatch($request)
	{
		$this->_router->route($request);

		$controllerName = $request->getControllerName();

		try {
			$reflectionClass = new \ReflectionMethod(
				$this->_controllerFactory,
				self::_getControllerInjectorMethod($controllerName)
			);
			$controller = $reflectionClass->invoke($this->_controllerFactory);
		} catch (\ReflectionException $e) {
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

	private static function _getControllerInjectorMethod($controllerName)
	{
		return 'inject'.str_replace('\\', '', $controllerName);
	}
}