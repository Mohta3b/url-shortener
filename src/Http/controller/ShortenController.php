<?php

namespace Http\controller;

use Service\Handlers\ShortenHandler;
use Service\Response;


$url_shortener_handler_instance = new ShortenHandler();


$new_short_url = $url_shortener_handler_instance->urlShortener(isset($_POST['url']) ? $_POST['url'] : '');
Response::json(['short-url' => $new_short_url]);

