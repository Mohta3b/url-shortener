<?php

function ascii_to_dec($str, $start = 0, $end = -1)
{
    $result = "";
    if ($start < 0 or $start > $end) {
        return $str;
    }
    if ($end == -1) {
        $end = strlen($str);
    }
    for ($i = $start; $i < $end; $i++) {
        $result .= ord($str[$i]);
    }
    return $result;
}

function to_base($num, $b = 62)
{
    $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $r = $num % $b;
    $res = $base[$r];
    $q = floor($num / $b);
    while ($q) {
        $r = $q % $b;
        $q = floor($q / $b);
        $res = $base[$r] . $res;
    }
    return $res;
}

function to10($num, $b = 62)
{
    $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $limit = strlen($num);
    $res = strpos($base, $num[0]);
    for ($i = 1; $i < $limit; $i++) {
        $res = $b * $res + strpos($base, $num[$i]);
    }
    return $res;
}

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function base_path($path)
{
    return BASE_PATH . $path;
}


function abort($code = 404, $msg = 'Not Found')
{
    http_response_code($code);


    die();
}

