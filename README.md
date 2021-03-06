GitHub Gist Twig Extension
==========================

A simple [Twig](http://twig.sensiolabs.org/) extension for embedding
[GitHub](http://github.com) [Gist](http://gist.github.com) snippets
into Twig templates.

Requirements
------------

 * PHP: >=5.3.2
 * Twig: >=1.5,<2


Usage
-----

```php
<?php
use Dflydev\Twig\Extension\GitHubGist\GistTwigExtension;
$gistTwigExtension = new GistTwigExtension();
$twig->addExtension($gistTwigExtension);
```

Once enabled, gists can be embedded by:

```twig
{{ gist(3360578) }}
```


Advanced Usage
--------------

The `GistTwigExtension` can optionally accept a `TransportInterface`
and a `CacheInterface` implementation. By default `NativePhpTransport`
and `ArrayCache` are selected if not specified.


License
-------

MIT, see LICENSE.


Community
---------

If you have questions or want to help out, join us in the
[#dflydev](irc://irc.freenode.net/#dflydev) channel on irc.freenode.net.
