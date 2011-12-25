<?php
namespace mock\Injector;

class PartialMock
{
	public function get($name, $view)
	{
		if ($name == 'Mock') {
			$partial = new \mock\Partial\Mock();
			$partial->setView($view);
			$partial->setTemplateDir(TEST_DIR.'/template/Partial');
		}

		return null;
	}
}
