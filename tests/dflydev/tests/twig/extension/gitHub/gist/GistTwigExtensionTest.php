<?php

/*
 * This file is a part of GitHub Gist Twig Extension.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\tests\twig\extension\gitHub\gist;

use dflydev\twig\extension\gitHub\gist\GistTwigExtension;

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
        $transport = $this->getMock('dflydev\twig\extension\gitHub\gist\transport\ITransport');
        $cache = $this->getMock('dflydev\twig\extension\gitHub\gist\cache\ICache');
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
        $transport = $this->getMock('dflydev\twig\extension\gitHub\gist\transport\ITransport');
        $transport
            ->expects($this->once())
            ->method('fetchGist')
            ->with($this->equalTo('1234'))
            ->will($this->returnValue($this->getDefaultPayloadSingle()));
        $cache = $this->getMock('dflydev\twig\extension\gitHub\gist\cache\ICache');
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
        $transport = $this->getMock('dflydev\twig\extension\gitHub\gist\transport\ITransport');
        $cache = $this->getMock('dflydev\twig\extension\gitHub\gist\cache\ICache');
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
        $transport = $this->getMock('dflydev\twig\extension\gitHub\gist\transport\ITransport');
        $cache = $this->getMock('dflydev\twig\extension\gitHub\gist\cache\ICache');
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
        $transport = $this->getMock('dflydev\twig\extension\gitHub\gist\transport\ITransport');
        $cache = $this->getMock('dflydev\twig\extension\gitHub\gist\cache\ICache');
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