<?php
namespace Kifs\Controller;

class Action
{
	protected $_request;

	protected $_response;

	protected $_view;

	public function __construct()
	{
	}

	/**
	 * @param Kifs\Controller\Request\Http $request
	 * @return Kifs\Controller\Response\AbstractResponse
	 */
	public function dispatch($request)
	{
		$this->_request = $request;

		$this->_dispatch();

		$templateName = $this->_getFormatedTemplateName();
		$this->_response->appendContent($this->_view->fetch($templateName));

		return $this->_response;
	}

	public function setResponse($response)
	{
		$this->_response = $response;
	}

	public function setView($view)
	{
		$this->_view = $view;
	}

	protected function _dispatch()
	{
	}

	private function _getFormatedTemplateName()
	{
		$names = explode('\\', get_class($this));
		array_shift($names);
		$templateName = implode('\\', $names);

		return $templateName;
	}

}
