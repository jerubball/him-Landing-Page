<?php
    header("Content-Type: text/plain");
    $domain = '';
    if (isset($_SERVER['REQUEST_SCHEME'])) {
        $domain = $_SERVER['REQUEST_SCHEME'].'://';
    } elseif (isset($_SERVER['HTTPS'])) {
        $domain = 'https://';
    } else {
        $domain = 'http://';
    }
    if (isset($_SERVER['HTTP_HOST'])) {
        $domain .= $_SERVER['HTTP_HOST'].'/';
    } elseif (isset($_SERVER['SERVER_NAME'])) {
        $domain .= $_SERVER['SERVER_NAME'].'/';
    } else {
        $domain .= 'hasol.co/';
    }
    
    echo "\r\n";
    echo $domain."\r\n";
    
    $file = file('sitemap.txt');
    if ($file && sizeof($file) > 1) {
        foreach ($file as $line) {
            if (strlen($line) > 0) {
                echo $domain.$line."\r\n";
            }
        }
    } else {
    }
?>
