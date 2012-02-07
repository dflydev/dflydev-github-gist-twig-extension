<?php

/*
 * This file is a part of GitHub Gist Twig Extension.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\twig\extension\gitHub\gist;

use dflydev\twig\extension\gitHub\gist\cache\ArrayCache;
use dflydev\twig\extension\gitHub\gist\cache\ICache;
use dflydev\twig\extension\gitHub\gist\transport\ITransport;
use dflydev\twig\extension\gitHub\gist\transport\NativePhpTransport;

class GistTwigExtension extends \Twig_Extension
{
    /**
     * Transport
     * @var ITransport
     */
    protected $transport;

    /**
     * Cache
     * @var ICache
     */
    protected $cache;

    /**
     * Constructor
     * @param ITransport $transport
     * @param ICache $cache
     */
    public function __construct(ITransport $transport = null, ICache $cache = null)
    {
        $this->transport = $transport !== null ? $transport : new NativePhpTransport();
        $this->cache = $cache !== null ? $cache : new ArrayCache();
    }

    /**
     * {@inheritdoc }
     */
    public function getFunctions()
    {
        return array(
            'gist' => new \Twig_Function_Method($this, 'gist', array('pre_escape' => 'html', 'is_safe' => array('html'),)),
        );
    }

    /**
     * Get the HTML content for a GitHub gist
     * @param string $id
     * @param string $file
     */
    public function gist($id, $file = null)
    {
        if ($this->cache->exists($id)) {
            $gist = $this->cache->get($id);
        } else {
            $gist = $this->transport->fetchGist($id);
            $this->cache->set($id, $gist);
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
     * {@inheritdoc }
     */
    public function getName()
    {
        return 'gitHubGist';
    }
}
