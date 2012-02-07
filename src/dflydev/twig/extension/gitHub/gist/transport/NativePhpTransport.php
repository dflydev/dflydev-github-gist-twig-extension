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

class NativePhpTransport implements ITransport
{
    /**
     * Base URI
     * @var string
     */
    protected $baseUri;

    /**
     * Constructor
     * @param string $baseUri
     */
    public function __construct($baseUri = 'https://api.github.com/gists/')
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @{inheritdoc}
     */
    public function fetchGist($id)
    {
        $response = file_get_contents($this->baseUri.$id);
        return json_decode($response, true);
    }
}