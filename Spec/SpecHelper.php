<?php

require_once __DIR__.'/../../../../vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Xaddax'         => __DIR__.'/../../../',
));
$loader->registerPrefixes(array(
    'OpenDocument'     => __DIR__.'/../../../../vendor/php-opendocument',
));

$loader->register();