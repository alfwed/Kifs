<?php
namespace Kifs\Application;

class Benchmarker
{
	private $_markers = array();

	private $_parentMarker;


	public function __construct()
	{

	}

	public function openMarker($name)
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

	public function closeMarker($name)
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

	public function display()
	{

	}

}
