<?php
namespace Controller;

class Dummy extends \Kifs\Controller\Action
{
	private $_dummyDao;


	public function __construct($dummyDao)
	{
		$this->_dummyDao = $dummyDao;
	}

	public function _dispatch()
	{
		$this->_view->messages = $this->_dummyDao->getMessageByUser('alfwed');
		var_dump($this->_view->messages);
	}
}
