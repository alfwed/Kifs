<?php
namespace Kifs\Controller\Response;

class Http implements Response
{
	private $_headers = array();

	private $_content = '';


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

	public function setHeader($name, $value)
	{
		$this->_headers[$name] = $value;
	}

	public function appendContent($content)
	{
		$this->_content .= $content;
	}
}
