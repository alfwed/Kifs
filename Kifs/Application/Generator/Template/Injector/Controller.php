<?php echo <<<'EOD'
<?php
namespace Injector;

class Controller extends \Kifs\Injector\Controller
{
	/**
	 * @var Model
	 */
	private $_modelInjector;

	/**
	 * @var Business
	 */
	private $_businessInjector;

	/**
	 * @param \Kifs\Application\Scope $appScope
	 * @param Model $modelInjector
	 * @param Business $businessInjector
	 */
	public function __construct($appScope, $modelInjector, $businessInjector)
	{
		parent::__construct($appScope);
		$this->_modelInjector = $modelInjector;
		$this->_businessInjector = $businessInjector;
	}

	public function injectError404()
	{
		return new \Controller\Error404();
	}

	public function injectIndex()
	{
		return new \Controller\Index();
	}

}
EOD;
