<?php

$router->get('/', 'IndexController.php');

$router->post('/shorten', 'ShortenController.php');

$router->get('/{shortUrl}', 'RedirectController.php');