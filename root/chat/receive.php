<?php
  
  header("Content-Type: text/plain");
  
  session_start();
  
  if (!$_SESSION['init']) {
    echo '1 Session not initialized.';
  } elseif (!file_exists('.chat') || !file_exists('chat')) {
    echo '2 Chat room not found.';
  } else {
    $_SESSION['lasttime'] = $_SESSION['timestamp'];
    $_SESSION['timestamp'] = time();
    $chat = fopen('chat', 'r');
    $data = [];
    while (!feof($chat)) {
        $line = $fgets($chat);
        // skip empty or commented line
        if (strlen($line) > 0 && $line[0] !== '#') {
            $items = explode("\t", $line);
            // when time was after last check
            if (sizeof($items) > 0 && intval($items) > $_SESSION['lasttime']) {
                // use line.
                array_push($data, $line);
            }
        }
    }
    fclose($chat);
    
    foreach ($data as $entry) {
        echo $entry."\r\n"
    }
  }
  
?>