<?php
namespace Kifs\Cache;

interface Cache
{
	/**
	 * Return the content of the cache $id
	 *
	 * @param string $id
	 */
	public function get($id);

	/**
	 * Set the content of the cache $id. The content will be cache for at least
	 * $time seconds. If $time equals 0 then the content will be cached forever
	 *
	 * @param string $id
	 * @param string $content
	 * @param int $time
	 */
	public function set($id, $content, $time = 0);

	/**
	 * Returns true if a cache $id exists
	 *
	 * @param string $id
	 */
	public function isCached($id);
}