<?php
namespace Kifs\Cache;

class File implements Cache
{
	/**
	 * Length of the token containing the expiration date in chars
	 *
	 * @var int
	 */
	const TIME_TOKEN_LENGTH = 14;

	/**
	 * Directory where the files will be stored
	 *
	 * @var string
	 */
	private $_cacheDir;


	public function __construct($cacheDir)
	{
		$this->_cacheDir = $cacheDir;
	}

	public function get($id)
	{
		if (!$this->isCached($id))
			return null;

		$content = file_get_contents($this->_getFilename($id));

		return substr($content, self::TIME_TOKEN_LENGTH);
	}

	public function set($id, $content, $time = 0)
	{
		if ($this->isCached($id))
			unlink($this->_getFilename());

		$content = $this->_getTimeToken($time).$content;

		return file_put_contents($this->_getFilename($id), $content, FILE_BINARY);
	}

	public function isCached($id)
	{
		if (!file_exists($this->_getFilename($id)))
			return false;

		// FIXME replace by fread(self::TIME_TOKEN_LENGTH);
		$content = file_get_contents($this->_getFilename($id));
		$expirationDate = substr($content, 0, self::TIME_TOKEN_LENGTH);

		return (date('YmdHis') < $expirationDate);
	}

	private function _getFilename($id)
	{
		return $this->_cacheDir.'/'.$id.'.cache';
	}

	private function _getTimeToken($time)
	{
		return date('YmdHis', time()+$time);
	}
}
