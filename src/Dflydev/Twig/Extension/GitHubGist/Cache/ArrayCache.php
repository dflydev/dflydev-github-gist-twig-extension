<?php

/*
 * This file is a part of GitHub Gist Twig Extension.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Twig\Extension\GitHubGist\Cache;

/**
 * Array Cache.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class ArrayCache implements CacheInterface
{
    /**
     * Internal cache
     *
     * @var array
     */
    protected $cache = array();

    /**
     * Constructor
     * @param array $cache Default cache structure
     */
    public function __construct(array $cache = array())
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($id)
    {
        return array_key_exists($id, $this->cache);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->cache[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function set($id, $content)
    {
        $this->cache[$id] = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function expire($id)
    {
        unset($this->cache[$id]);
    }
}
