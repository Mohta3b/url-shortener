<?php


$container = new \UrlShortener\Http\Container();

$container->bind(\UrlShortener\Service\Database::class, function () {
    $config = require_once base_path('config/database.php');

    return new \UrlShortener\Service\Database($config);
});

\UrlShortener\Http\App::setContainer($container);

