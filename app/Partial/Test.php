<?php
namespace Partial;

class Test extends \Kifs\Partial\AbstractPartial
{

	protected function _render()
	{
		$this->_params['foo'] = 'bar';
	}

}
