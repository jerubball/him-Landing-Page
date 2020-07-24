<?php
    header('Content-Type: text/plain');
    
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
    
    function listdir($domain, $path = '', $depth = null) {
        if (!isset($depth) || $depth > 0) {
            $nextdepth = isset($depth) ? $depth - 1 : null;
            $output = scandir('./'.$path);
            natcasesort($output);
            foreach ($output as $item) {
                if ($item[0] !== '.') {
                    if (is_dir($path.$item)) {
                        $nextpath = $path.$item.'/';
                        echo $domain.$nextpath."\r\n";
                        listdir($domain, $nextpath, $nextdepth);
                    } else {
                        echo $domain.$path.$item."\r\n";
                    }
                }
            }
        }
    }
    
    echo "\r\n";
    echo $domain."\r\n";
    
    $file = file('sitemap.txt');
    if ($file && sizeof($file) > 1) {
        foreach ($file as $line) {
            $lin = trim($line);
            if (strlen($lin) > 0) {
                echo $domain.$lin."\r\n";
            } else {
                echo "\r\n";
            }
        }
    } else {
        // exec('tree -filNQ --noreport', $output);
        chdir('..');
        listdir($domain);
    }
    
    echo "\r\n";
?>
