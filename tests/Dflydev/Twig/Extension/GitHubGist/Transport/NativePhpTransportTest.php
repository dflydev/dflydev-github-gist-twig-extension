<?php

/*
 * This file is a part of GitHub Gist Twig Extension.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Twig\Extension\GitHubGist\Transport;

use Dflydev\Twig\Extension\GitHubGist\Transport\NativePhpTransport;

class NativePhpTransportTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchGist()
    {
        $transport = new NativePhpTransport(__DIR__.'/fixtures/');
        $gist = $transport->fetchGist(1234);
        $this->assertEquals('1757612', $gist['id'], 'Should have a valid ID');
    }
}
