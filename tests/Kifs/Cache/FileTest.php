<?php
namespace Kifs\Cache;

/**
 * Test class for File.
 * Generated by PHPUnit on 2011-12-20 at 16:32:30.
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var File
     */
    protected $cache;

    private $cacheDir;


    protected function setUp()
    {
        $this->cacheDir = TEST_DIR.'/cache';

        if (file_exists($this->cacheDir.'/foo.cache'))
            unlink($this->cacheDir.'/foo.cache');

        if (file_exists($this->cacheDir.'/bar.cache'))
            unlink($this->cacheDir.'/bar.cache');

        $this->cache = new File($this->cacheDir);
    }

    public function testGet()
    {
        $expiration = date('YmdHis', time()+30);
        file_put_contents($this->cacheDir.'/foo.cache', $expiration.'Content for key foo');

        $this->assertEquals('Content for key foo', $this->cache->get('foo'));
    }

    public function testSet()
    {
        $expiration = date('YmdHis', time()+30);
        $this->cache->set('bar', 'Content for key bar', 30);

        $content = file_get_contents($this->cacheDir.'/bar.cache');
        $content_exp = substr($content, 0, 14);
        $content = substr($content, 14);

        $this->assertEquals('Content for key bar', $content);
        $this->assertTrue($content_exp > $expiration - 1);
        $this->assertTrue($content_exp < $expiration + 1);
    }

    public function testIsCached()
    {
        $expiration = date('YmdHis', time()+30);
        file_put_contents($this->cacheDir.'/foo.cache', $expiration.'Content for key foo');

        $this->assertTrue($this->cache->isCached('foo'));
        $this->assertFalse($this->cache->isCached('baz'));
    }
}
