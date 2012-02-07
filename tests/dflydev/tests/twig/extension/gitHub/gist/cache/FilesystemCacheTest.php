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

/**
 * These tests require the vfsStream mock filesystem driver
 * from https://github.com/mikey179/vfsStream/
 */
require_once 'vfsStream/vfsStream.php';

use dflydev\twig\extension\gitHub\gist\cache\FilesystemCache;

class FilesystemCacheTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        \vfsStreamWrapper::register();
        \vfsStream::setup('root', null, array('a' => serialize(array('test' => 'Hello World'))));
    }
    public function testExists()
    {
        $cache = new FilesystemCache(\vfsStream::url('root'));
        $this->assertTrue($cache->exists('a'), 'Should find that "a" exists in cache');
        $this->assertFalse($cache->exists('b'), 'Should not find that "b" exists in cache');
    }

    public function testGet()
    {
        $cache = new FilesystemCache(\vfsStream::url('root'));
        $content = $cache->get('a');
        $this->assertEquals('Hello World', $content['test'], 'Should get valid content for "a" from cache');
    }

    public function testSet()
    {
        $cache = new FilesystemCache(\vfsStream::url('root'));
        $cache->set('c', array('test' => 'Hello World'));
        $content = $cache->get('c');
        $this->assertEquals('Hello World', $content['test'], 'Should get valid content for "c" from cache');
        $cache->set('c', array('test' => 'Hello World Too'));
        $content = $cache->get('c');
        $this->assertEquals('Hello World Too', $content['test'], 'Should get valid rewritten content for "c" from cache');
    }

    public function testExpire()
    {
        $cache = new FilesystemCache(\vfsStream::url('root'));
        $this->assertTrue($cache->exists('a'), 'Should find that "a" exists in cache');
        $cache->expire('a');
        $this->assertFalse($cache->exists('a'), 'Should no longer find that "a" exists in cache');
    }
}