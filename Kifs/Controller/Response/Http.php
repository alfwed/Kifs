<?php
namespace Kifs\Controller\Response;

class Http implements Response
{
	/**
	 * Array of HTTP headers
	 *
	 * @var array
	 */
	protected $_headers = array();

	/**
	 * Body of the response
	 *
	 * @var string
	 */
	protected $_content = '';


	public function __construct()
	{
	}

	public function send()
	{
		foreach ($this->_headers as $name => $value) {
			header($name.': '.$value);
		}

		echo $this->_content;
	}

	public function appendContent($content)
	{
		$this->_content .= $content;
	}

	public function getContent()
	{
		return $this->_content;
	}

	public function clear()
	{
		$this->_content = '';
	}

	/**
	 * Add a header to the response
	 *
	 * @param string $name Header's name
	 * @param string $value Header's value
	 */
	public function setHeader($name, $value)
	{
		$this->_headers[$name] = $value;
	}
}
