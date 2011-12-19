<?php
namespace Kifs\Cache;

class Dummy implements Cache
{
	public function get($id)
	{
		return null;
	}

	public function set($id, $content, $time = 0)
	{
		return true;
	}

	public function isCached($id)
	{
		return false;
	}
}
