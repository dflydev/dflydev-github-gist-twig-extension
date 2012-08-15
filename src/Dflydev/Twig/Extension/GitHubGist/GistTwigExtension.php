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
use Dflydev\Twig\Extension\GitHubGist\Cache\CacheInterface;
use Dflydev\Twig\Extension\GitHubGist\Transport\NativePhpTransport;
use Dflydev\Twig\Extension\GitHubGist\Transport\TransportInterface;

/**
 * GitHub Gist Twig Extension.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class GistTwigExtension extends \Twig_Extension
{
    /**
     * Transport
     *
     * @var TransportInterface
     */
    private $transport;

    /**
     * Cache
     *
     * @var CacheInterface
     */
    private $cache;

    /**
     * Constructor
     *
     * @param TransportInterface $transport Transport
     * @param CacheInterface     $cache     Cache
     */
    public function __construct(TransportInterface $transport = null, CacheInterface $cache = null)
    {
        $this->transport = $transport;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'gist' => new \Twig_Function_Method($this, 'gist', array('pre_escape' => 'html', 'is_safe' => array('html'),)),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gitHubGist';
    }

    /**
     * Get the HTML content for a GitHub Gist
     *
     * @param string $id   ID
     * @param string $file File
     *
     * @return string
     */
    public function gist($id, $file = null)
    {
        if ($this->cache()->exists($id)) {
            $gist = $this->cache()->get($id);
        } else {
            $gist = $this->transport()->fetchGist($id);
            $this->cache()->set($id, $gist);
        }
        $files = array();
        foreach ($gist['files'] as $name => $fileInfo) {
            if ($file === null) {
                $files[$name] = $fileInfo;
            } else {
                if ($file == $name) {
                    $files[$name] = $fileInfo;
                    break;
                }
            }
        }

        if (!count($files)) {
            return '';
        }

        $urlExtra = $file ? '?file='.$file : '';
        $output = '';
        $output .= '<script src="https://gist.github.com/'.$id.'.js'.$urlExtra.'"></script>';
        $output .= '<noscript>';
        foreach ($files as $name => $fileInfo) {
            $language = strtolower($fileInfo['language']);
            $output .= '<pre><code class="language-'.$language.' '.$language.'">';
            $output .= htmlentities($fileInfo['content']);
            $output .= '</code></pre>';
        }
        $output .= '</noscript>';

        return $output;
    }

    /**
     * Transport
     *
     * @return TransportInterface
     */
    public function transport()
    {
        if (null === $this->transport) {
            $this->transport = new NativePhpTransport;
        }

        return $this->transport;
    }

    /**
     * Set Transport
     *
     * @param TransportInterface $transport Transport
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Cache
     *
     * @return CacheInterface
     */
    public function cache()
    {
        if (null === $this->cache) {
            $this->cache = new ArrayCache;
        }

        return $this->cache;
    }

    /**
     * Set Cache
     *
     * @param CacheInterface $cache Cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }
}
