<?php
namespace Kifs\View;

class Standard implements View
{
	/**
	 * Path to the directory of templates
	 *
	 * @var string
	 */
	private $_templateDir;

	/**
	 * Path to the directory where the templates of partials are stored
	 *
	 * @var string
	 */
	private $_partialDir;

	/**
	 * @var \Injector\Partial
	 */
	private $_partialFactory;

	/**
	 * Array of view helpers. There is no specific interface for helpers.
	 * You can register pretty much whatever you want.
	 *
	 * @var array
	 */
	private $_helpers = array();


	/**
	 * @param string $templateDir
	 * @param string $partialFactory
	 */
	public function __construct($templateDir, $partialFactory)
	{
		$this->_templateDir = $templateDir;
		$this->_partialDir = $templateDir.'/Partial';
		$this->_partialFactory = $partialFactory;
	}

	/**
	 * Fetch the content of the template $templateName and returns it
	 *
	 * @param string $templateName Path to the template to fetch
	 */
	public function fetch($templateName)
	{
		ob_start();
		require $this->_templateDir.'/'.$templateName.'.php';
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * Registers the view helper $helper under the name $name
	 *
	 * @param string $name
	 * @param object $helper
	 */
	public function registerHelper($helper)
	{
		$helperName = get_class($helper);
		$helperName = substr($helperName, strrpos($helperName, '\\')+1);

		$this->_helpers[$helperName] = $helper;
	}

	/**
	 * Returns the view helper named $name if it was registered before
	 * or null otherwise
	 *
	 * @param $name $name
	 */
	public function getHelper($name)
	{
		if (isset($this->_helpers[$name]))
			return $this->_helpers[$name];

		return null;
	}

	/**
	 * Return the content of the partial named $name. You can pass parameters
	 * to the template of the partial in $params
	 *
	 * @param string $name
	 * @param array $params
	 * @return void
	 */
	public function partial($name, $params = array())
	{
		if (null !== $partial = $this->_partialFactory->get($name, $this)) {
			echo $partial->fetch($params);
			return;
		}

		if (file_exists($this->_templateDir.'/Partial/'.ucfirst($name).'.php')) {
			extract($params);
			include $this->_templateDir.'/Partial/'.ucfirst($name).'.php';
			return;
		}

		throw new \Exception('Unable to find partial "'.$name.'"');
	}

}
