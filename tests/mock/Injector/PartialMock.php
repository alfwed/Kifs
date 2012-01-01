<?php
namespace mock\Injector;

class PartialMock
{
	public function get($name, $view)
	{
		$partial = new \mock\Partial\Mock();
		$partial->setView($view);
		$partial->setTemplateDir(TEST_DIR.'/template');
		$partial->setTemplateName($name);
		return $partial;
	}
}
