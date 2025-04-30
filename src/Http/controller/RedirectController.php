<?php

namespace Http\controller;

use Service\Handlers\RedirectHandler;
use Service\Response;

$redirect_handler_instance = new RedirectHandler();


$uri = ltrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$redirect_link = $redirect_handler_instance->getOriginalUrl($uri);
//dd($redirect_link);

// redirect to redirect link
if ($redirect_link) {
    header("Location: $redirect_link", true, 302);
    exit;
} else {
    // Optionally handle a case where the short URL doesn't exist
    Response::json(['error' => '404 Not Found'], 404);
    exit;
}