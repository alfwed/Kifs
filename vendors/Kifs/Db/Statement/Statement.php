<?php
namespace Kifs\Db\Statement;

abstract class Statement
{
	protected $_stmt;


	public function __construct($stmt)
	{
		$this->_stmt = $stmt;
	}

	/**
	 * Execute the statement with the bind values provided in $params
	 *
	 * @param array $params
	 */
	abstract public function execute($params);

	/**
	 * Fetch a result from the statement
	 *
	 * @param int $fetchMode
	 */
	abstract public function fetch($fetchMode);

	/**
	 * Fetch all results from the statement
	 *
	 * @param int $fetchMode
	 */
	abstract public function fetchAll($fetchMode);

}
