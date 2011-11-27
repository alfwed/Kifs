<?php
namespace Controller;

class Dummy extends \Kifs\Controller\Action
{
	/**
	 * @var \Model\Dummy
	 */
	private $_dummyDao;


	/**
	 * @param \Model\Dummy
	 */
	public function __construct($dummyDao)
	{
		$this->_dummyDao = $dummyDao;
	}

	public function _dispatch()
	{
		$this->_view->messages = $this->_dummyDao->getMessagesByUser('alfwed');
	}
}
