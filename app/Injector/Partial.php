<?php
namespace Injector;

class Partial extends \Kifs\Injector\Partial
{

	public function injectTest()
	{
		return new \Partial\Test();
	}

}
