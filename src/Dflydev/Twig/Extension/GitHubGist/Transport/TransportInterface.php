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

/**
 * Transport Interface.
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface TransportInterface
{
    /**
     * Fetch the contents of a gist
     *
     * @param array $id
     */
    public function fetchGist($id);
}
