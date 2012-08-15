<?php

/*
 * This file is a part of GitHub Gist Twig Extension.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Twig\Extension\GitHubGist;

use Dflydev\Twig\Extension\GitHubGist\Cache\ArrayCache;
use Dflydev\Twig\Extension\GitHubGist\GistTwigExtension;
use Dflydev\Twig\Extension\GitHubGist\Transport\NativePhpTransport;

/**
 * GitHub Gist Twig Extension Test.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class GistTwigExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFunctions()
    {
        $gistTwigExtension = new GistTwigExtension();
        $functions = $gistTwigExtension->getFunctions();
        $this->assertTrue(array_key_exists('gist', $functions), 'Should find "gist" to be a valid function');
    }

    public function testGetName()
    {
        $gistTwigExtension = new GistTwigExtension();
        $this->assertEquals('gitHubGist', $gistTwigExtension->getName(), 'Should have name "gitHubGist"');
    }

    public function testGistCacheSingle()
    {
        $transport = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Transport\TransportInterface');
        $cache = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Cache\CacheInterface');
        $cache
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue(true));
        $cache
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue($this->getDefaultPayloadSingle()));
        $gistTwigExtension = new GistTwigExtension($transport, $cache);
        $this->assertEquals($this->getDefaultPayloadSingleFixture(), $gistTwigExtension->gist(1234), 'Should get valid HTML response');
    }

    public function testGistTransportSingle()
    {
        $transport = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Transport\TransportInterface');
        $transport
            ->expects($this->once())
            ->method('fetchGist')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue($this->getDefaultPayloadSingle()));
        $cache = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Cache\CacheInterface');
        $cache
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue(false));
        $gistTwigExtension = new GistTwigExtension($transport, $cache);
        $this->assertEquals($this->getDefaultPayloadSingleFixture(), $gistTwigExtension->gist(1234), 'Should get valid HTML response');
    }

    public function testGistCacheMultiple()
    {
        $transport = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Transport\TransportInterface');
        $cache = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Cache\CacheInterface');
        $cache
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue(true));
        $cache
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue($this->getDefaultPayloadMultiple()));
        $gistTwigExtension = new GistTwigExtension($transport, $cache);
        $this->assertEquals($this->getDefaultPayloadMultipleFixture(), $gistTwigExtension->gist(1234), 'Should get valid HTML response');
    }

    public function testGistCacheMultipleWithFileSpecified()
    {
        $transport = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Transport\TransportInterface');
        $cache = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Cache\CacheInterface');
        $cache
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue(true));
        $cache
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue($this->getDefaultPayloadMultiple()));
        $gistTwigExtension = new GistTwigExtension($transport, $cache);
        $this->assertEquals($this->getDefaultPayloadWithFileSpecifiedFixture(), $gistTwigExtension->gist(1234, 'simple.txt'), 'Should get valid HTML response');
    }

    public function testGistCacheEmpty()
    {
        $transport = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Transport\TransportInterface');
        $cache = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Cache\CacheInterface');
        $cache
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue(true));
        $cache
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue($this->getEmptyPayload()));
        $gistTwigExtension = new GistTwigExtension($transport, $cache);
        $this->assertEquals('', $gistTwigExtension->gist(1234), 'Should get empty HTML response');
    }

    public function testDefaultCache()
    {
        $gistTwigExtension = new GistTwigExtension;
        $this->assertTrue($gistTwigExtension->cache() instanceof ArrayCache);
    }

    public function testDefaultTransport()
    {
        $gistTwigExtension = new GistTwigExtension;
        $this->assertTrue($gistTwigExtension->transport() instanceof NativePhpTransport);
    }

    public function testSetCacheAndTransport()
    {
        $transport = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Transport\TransportInterface');
        $transport
            ->expects($this->once())
            ->method('fetchGist')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue($this->getDefaultPayloadSingle()));
        $cache = $this->getMock('Dflydev\Twig\Extension\GitHubGist\Cache\CacheInterface');
        $cache
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue(false));

        $gistTwigExtension = new GistTwigExtension;
        $gistTwigExtension->setTransport($transport);
        $gistTwigExtension->setCache($cache);
        $this->assertEquals($this->getDefaultPayloadSingleFixture(), $gistTwigExtension->gist(1234), 'Should get valid HTML response');
    }

    protected function getDefaultPayloadSingleFixture()
    {
        return <<<EOT
<script src="https://gist.github.com/1234.js"></script><noscript><pre><code class="language-text text">Plain text</code></pre></noscript>
EOT
            ;
    }

    protected function getDefaultPayloadSingle()
    {
        return array(
            'files' => array(
                'simple.txt' => array(
                    'language' => 'text',
                    'content' => 'Plain text',
                ),
            ),
        );
    }

    protected function getDefaultPayloadMultipleFixture()
    {
        return <<<EOT
<script src="https://gist.github.com/1234.js"></script><noscript><pre><code class="language-text text">Plain text</code></pre><pre><code class="language-php php">&lt;?php /* Some PHP */ ?&gt;</code></pre></noscript>
EOT
    ;
    }

    protected function getDefaultPayloadMultiple()
    {
        return array(
            'files' => array(
                'simple.txt' => array(
                    'language' => 'text',
                    'content' => 'Plain text',
                ),
                'sample.php' => array(
                    'language' => 'php',
                    'content' => '<?php /* Some PHP */ ?>',
                ),
            ),
        );
    }

    protected function getDefaultPayloadWithFileSpecifiedFixture()
    {
        return <<<EOT
<script src="https://gist.github.com/1234.js?file=simple.txt"></script><noscript><pre><code class="language-text text">Plain text</code></pre></noscript>
EOT
        ;
    }

    protected function getEmptyPayload()
    {
        return array(
            'files' => array(),
        );
    }
}
