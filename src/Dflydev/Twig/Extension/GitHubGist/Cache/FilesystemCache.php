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
 * Filesystem Cache.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class FilesystemCache implements CacheInterface
{
    /**
     * Base path
     *
     * @var string
     */
    protected $basePath;

    /**
     * Constructor
     *
     * @param string $basePath Base path
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($id)
    {
        return file_exists($this->generatePathname($id));
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return unserialize(file_get_contents($this->generatePathname($id)));
    }

    /**
     * {@inheritdoc}
     */
    public function set($id, $content)
    {
        file_put_contents($this->generatePathname($id), serialize($content));
    }

    /**
     * {@inheritdoc}
     */
    public function expire($id)
    {
        unlink($this->generatePathname($id));
    }

    /**
     * Generate a pathname for an ID
     *
     * @param string $id ID
     *
     * @return string
     */
    protected function generatePathname($id)
    {
        return $this->basePath.'/'.$id;
    }
}
