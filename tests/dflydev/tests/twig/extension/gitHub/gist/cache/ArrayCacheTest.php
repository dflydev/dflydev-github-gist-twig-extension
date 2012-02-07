<?php

/*
 * This file is a part of GitHub Gist Twig Extension.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\tests\twig\extension\gitHub\gist\cache;

use dflydev\twig\extension\gitHub\gist\cache\ArrayCache;

class ArrayCacheTest extends \PHPUnit_Framework_TestCase
{
    public function testExists()
    {
        $cache = new ArrayCache(array('a' => array()));
        $this->assertTrue($cache->exists('a'), 'Should find that "a" exists in cache');
        $this->assertFalse($cache->exists('b'), 'Should not find that "b" exists in cache');
    }

    public function testGet()
    {
        $cache = new ArrayCache(array('a' => array('test' => 'Hello World')));
        $content = $cache->get('a');
        $this->assertEquals('Hello World', $content['test'], 'Should get valid content for "a" from cache');
    }

    public function testSet()
    {
        $cache = new ArrayCache();
        $cache->set('a', array('test' => 'Hello World'));
        $content = $cache->get('a');
        $this->assertEquals('Hello World', $content['test'], 'Should get valid content for "a" from cache');
        $cache->set('a', array('test' => 'Hello World Too'));
        $content = $cache->get('a');
        $this->assertEquals('Hello World Too', $content['test'], 'Should get valid rewritten content for "a" from cache');
    }

    public function testExpire()
    {
        $cache = new ArrayCache(array('a' => array()));
        $this->assertTrue($cache->exists('a'), 'Should find that "a" exists in cache');
        $cache->expire('a');
        $this->assertFalse($cache->exists('a'), 'Should no longer find that "a" exists in cache');
    }
}