<?php
namespace Kifs\Controller;

abstract class Action
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
	 * @var \Kifs\View\View
	 */
	protected $_view;

	protected $_enableView = true;

	protected $_enableLayout = true;


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

		$this->_preRendering();

		if ($this->_enableView) {
    		$templateName = $this->_getFormatedTemplateName();
    		$this->_response->appendContent($this->_view->fetch($templateName));
		}

		return $this->_response;
	}

	/**
	 * Set the response used by the controller
	 *
	 * @param \Kifs\Controller\Response\Http $response
	 * @return void
	 */
	public function setResponse($response)
	{
		$this->_response = $response;
	}

	/**
	 * Set the view used by the controller
	 *
	 * @param \Kifs\View\View $view
	 * @return void
	 */
	public function setView($view)
	{
		$this->_view = $view;
	}

	/**
	 * Called before rendering the view. This is where you do all your business.
	 *
	 * @return void
	 */
	abstract protected function _preRendering();

	/**
	 * Returns the name of the template corresponding to this controller
	 *
	 * @return string
	 */
	private function _getFormatedTemplateName()
	{
		$names = explode('\\', get_class($this));
		array_shift($names);
		$templateName = \Kifs\Application\Path::DIR_NAME_CONTROLLER . '/' . implode('/', $names);

		return $templateName;
	}

	protected function _setEnableView($b)
	{
	    $this->_enableView = $b;
	}

	public function enableLayout()
	{
	    return $this->_enableLayout;
	}

	protected function _setEnableLayout($b)
	{
	    $this->_enableLayout = $b;
	}

}
