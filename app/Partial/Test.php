<?php
namespace Partial;

class Test extends \Kifs\Partial\AbstractPartial
{

	protected function _preRendering()
	{
		$this->foo = 'bar';
	}

}