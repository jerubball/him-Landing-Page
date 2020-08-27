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
      // read metadata
      $metadata = json_decode(file_get_contents($id_meta), true);
      if (!isset($metadata) || !is_array($metadata)) {
        $response['code'] = 3;
        $response['status'] = 'Unable to read metadata.';
      } elseif (!$metadata['enabled']) { // || $metadata['expired'] || $metadata['created']
        $response['code'] = 4;
        $response['status'] = 'Chatroom expired.';
      } else {
        $_SESSION['lasttime'] = $_SESSION['timestamp'];
        $_SESSION['timestamp'] = microtime(true);
        
        $data = [];
        // read data as text
        if ($metadata['mode'] == 'text') {
          $chat = fopen($id, 'r');
          flock($chat, LOCK_SH);
          while (!feof($chat)) {
            $line = fgets($chat);
            // skip empty or commented line
            if (strlen($line) > 0 && $line[0] !== '#') {
              $items = explode("\t", $line);
              // when time was after last check
              if (sizeof($items) >= 4) {
                $timestamp = floatval($items[0]);
                if ($timestamp >= $_SESSION['lasttime'] && $timestamp < $_SESSION['timestamp']) {
                  // use line.
                  //array_push($data, $line);
                  // use json.
                  array_push($data, ['time' => $timestamp, 'ip' => $items[1], 'name' => $items[2], 'text' => $items[3]]);
                }
              }
            }
          }
          flock($chat, LOCK_UN);
          fclose($chat);
        // read data as json
        } elseif ($metadata['mode'] == 'json') {
          $chat = json_decode(file_get_contents($id, LOCK_SH), true);
          $index = $_SESSION['lasttime'] == 0 ? 0 : sizeof($chat);
          while ($index > 0 && $chat[$index-1]['time'] >= $_SESSION['lasttime']) {
            $index--;
          }
          while ($index < sizeof($chat) && $chat[$index]['time'] < $_SESSION['timestamp']) {
            array_push($data, $chat[$index++];
          }
        // read data from mysql
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