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
use dflydev\twig\extension\gitHub\gist\GistTwigExtension;
$gistTwigExtension = new GistTwigExtension();
$twig->addExtension($gistTwigExtension);
```

Advanced Usage
--------------

The `GistTwigExtension` can optionally accept an `ITransport` and an `ICache`
implementation. By default `NativePhpTransport` and `ArrayCache` are
selected if not specified.

License
-------

This library is licensed under the New BSD License - see the LICENSE file for details.

Community
---------

If you have questions or want to help out, join us in the
[#dflydev](irc://irc.freenode.net/#dflydev) channel on irc.freenode.net.