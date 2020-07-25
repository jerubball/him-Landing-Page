<?php
  
  header('Content-Type: application/json');
  
  session_start();
  
  $response = [];
  
  if (!$_SESSION['init']) {
    $response['code'] = 1;
    $response['status'] = 'Session not initialized.';
  } elseif (!file_exists('.chat') || !file_exists('chat')) {
    $response['code'] = 2;
    $response['status'] = 'Chat room not found.';
  } else {
    $_SESSION['lasttime'] = $_SESSION['timestamp'];
    $_SESSION['timestamp'] = microtime(true);
    $data = [];
    $chat = fopen('chat', 'r');
    flock($chat, LOCK_SH);
    while (!feof($chat)) {
        $line = fgets($chat);
        // skip empty or commented line
        if (strlen($line) > 0 && $line[0] !== '#') {
            $items = explode("\t", $line);
            // when time was after last check
            if (sizeof($items) > 0) {
                $timestamp = floatval($items[0]);
                if ($timestamp >= $_SESSION['lasttime'] && $timestamp < $_SESSION['timestamp']) {
                    // use line.
                    array_push($data, $line);
                    // use json.
                }
            }
        }
    }
    flock($chat, LOCK_UN);
    fclose($chat);
    
    $response['code'] = 0;
    $response['status'] = 'Success.';
    $response['data'] = $data;
  }
  
  echo json_encode($response);
  
?>