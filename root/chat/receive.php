<?php
  
  header('Content-Type: application/json');
  
  session_start();
  
  $response = [];
  
  if (!$_SESSION['init']) {
    $response['code'] = 1;
    $response['status'] = 'Session not initialized.';
  } else {
    $id = $_SESSION['chatroom'];
    $id_meta = '.'.$_SESSION['chatroom'];
    if (!file_exists($id_meta)) {
      $response['code'] = 2;
      $response['status'] = 'Chat room not found.';
    } else {
      $metadata = json_decode(file_get_contents($id_meta));
      if (!isset($metadata) || !is_object($metadata)) {
        $response['code'] = 3;
        $response['status'] = 'Unable to read metadata.';
      } else {
        $_SESSION['lasttime'] = $_SESSION['timestamp'];
        $_SESSION['timestamp'] = microtime(true);
        
        $data = [];
        if ($metadata['mode'] == 'text') {
          $chat = fopen($id, 'r');
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
        } elseif ($metadata['mode'] == 'json') {
          
        } elseif ($metadata['mode'] == 'mysql') {
        }
        
        $response['code'] = 0;
        $response['status'] = 'Success.';
        $response['data'] = $data;
      }
    }
  }
  
  echo json_encode($response);
  
?>