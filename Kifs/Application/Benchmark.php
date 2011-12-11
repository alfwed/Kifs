<?php
namespace Kifs\Application;

class Benchmarker
{
	private static $_markers = array();

	private static $_parentMarker;


	public static function openMarker($name)
	{
		$marker = array(
			'name' => $name,
			'time' => microtime(true),
			'memory' => memory_get_usage(true),
			'parent' => &$this->_parentMarker,
			'childs' => array(),
		);

		$this->_parentMarker = &$marker;
		$this->_markers[] = $marker;
	}

	public static function closeMarker($name)
	{
		$marker = array(
			'name' => $name,
			'time' => microtime(),
			'memory' => memory_get_usage(true),
			'parent' => null,
			'child' => null,
		);

		if (!is_null($this->_parentMarker) && !is_null($this->_parentMarker['parent'])) {
			$marker['parent'] = $this->_parentMarker['parent']['childs'];
			$this->_parentMarker['parent']['childs'][] = $marker;
			return;
		}

		$this->_markers[] = $marker;
	}

	public static function display()
	{

	}

}
