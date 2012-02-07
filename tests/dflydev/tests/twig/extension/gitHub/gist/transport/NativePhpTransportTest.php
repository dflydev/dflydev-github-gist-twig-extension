<?php

/*
 * This file is a part of GitHub Gist Twig Extension.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use dflydev\twig\extension\gitHub\gist\transport\NativePhpTransport;

namespace dflydev\twig\extension\gitHub\gist\transport;

class NativePhpTransportTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchGist()
    {
        $transport = new NativePhpTransport(__DIR__.'/fixtures/');
        $gist = $transport->fetchGist(1234);
        $this->assertEquals('1757612', $gist['id'], 'Should have a valid ID');
    }
}