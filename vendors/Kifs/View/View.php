<?php
namespace Kifs\View;

interface View
{
	/**
	 * Fetch the content of the template $templateName and returns it
	 *
	 * @param string $templateName Path to the template to fetch
	 */
	public function fetch($templateName);

	/**
	 * Registers the view helper $helper under the name $name
	 *
	 * @param string $name
	 * @param object $helper
	 */
	public function registerHelper($helper);

	/**
	 * Returns the view helper named $name if it was registered before
	 * or null otherwise
	 *
	 * @param $name $name
	 */
	public function getHelper($name);

	/**
	 * Return the content of the partial named $name. You can pass parameters
	 * to the template of the partial in $params
	 *
	 * @param string $name
	 * @param array $params
	 */
	public function partial($name, $params);
}
