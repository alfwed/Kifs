<?php
namespace Kifs\Controller;

class Action
{
	/**
	 * @var \Kifs\Controller\Request\Http
	 */
	protected $_request;

	/**
	 * @var \Kifs\Controller\Response\Http
	 */
	protected $_response;

	/**
	 * @var \Kifs\View\Standard
	 */
	protected $_view;


	public function __construct()
	{
	}

	/**
	 * @param \Kifs\Controller\Request\Http $request
	 * @return \Kifs\Controller\Response\Http
	 */
	public function dispatch($request)
	{
		$this->_request = $request;

		$this->_dispatch();

		$templateName = $this->_getFormatedTemplateName();
		$this->_response->appendContent($this->_view->fetch($templateName));

		return $this->_response;
	}

	/**
	 * Set the response used by the controller
	 *
	 * @param \Kifs\Controller\Response\Http $response
	 */
	public function setResponse($response)
	{
		$this->_response = $response;
	}

	/**
	 * Set the view used by the controller
	 *
	 * @param \Kifs\View\Standard $view
	 */
	public function setView($view)
	{
		$this->_view = $view;
	}

	/**
	 * Called before rendering the view. This is where you do all your business.
	 */
	abstract protected function _dispatch();

	private function _getFormatedTemplateName()
	{
		$names = explode('\\', get_class($this));
		array_shift($names);
		$templateName = implode('\\', $names);

		return $templateName;
	}

}
