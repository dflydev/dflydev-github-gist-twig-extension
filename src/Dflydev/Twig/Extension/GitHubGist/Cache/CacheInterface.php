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
 * Cache Interface.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface CacheInterface
{
    /**
     * Determine if a gist exists
     *
     * @param unknown_type $id
     */
    public function exists($id);

    /**
     * Get the content of a gist
     *
     * @param string $id
     *
     * @return array
     */
    public function get($id);

    /**
     * Set the content of a gist
     *
     * @param string $id      ID
     * @param array  $content Content
     */
    public function set($id, $content);

    /**
     * Expire a gist
     *
     * @param string $id
     */
    public function expire($id);
}
