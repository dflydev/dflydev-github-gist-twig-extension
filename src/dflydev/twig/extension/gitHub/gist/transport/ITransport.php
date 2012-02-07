<?php

/*
 * This file is a part of GitHub Gist Twig Extension.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\twig\extension\gitHub\gist\transport;

interface ITransport
{
    /**
     * Fetch the contents of a gist
     * @param array $id
     */
    public function fetchGist($id);
}
