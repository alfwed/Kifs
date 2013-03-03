<?php
namespace Kifs\Application;

class Layout
{
	/**
	 * @var \Kifs\View\View
	 */
	protected $_view;

	/**
	 * @var \Kifs\Controller\Action
	 */
	protected $_controller;


	public function __construct()
	{
	}

	/**
	 * @param \Kifs\Controller\Request\Http $request
	 * @return \Kifs\Controller\Response\Http
	 */
	public function dispatch($request)
	{
		$response = $this->_controller->dispatch($request);
		/* @var \Kifs\Controller\Response\Http $response */
		$this->_view->content = $response->getContent();

		if ($this->_controller->enableLayout()) {
    		$response->clear();
    		$response->appendContent($this->_view->fetch('Layout'));
		}

		return $response;
	}

	/**
	 * Set the view used by the layout
	 *
	 * @param \Kifs\View\View $view
	 * @return void
	 */
	public function setView($view)
	{
		$this->_view = $view;
	}

	/**
	 * Set the controller to which the request will be dispatch.
	 *
	 * @param \Kifs\Controller\Action $controller
	 * @return void
	 */
	public function setController($controller)
	{
		$this->_controller = $controller;
	}
}
