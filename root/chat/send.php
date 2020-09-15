<?php
  
  header('Content-Type: application/json');
  
  session_start();
  
  $db_server = 'localhost';
  $db_username = 'website.local';
  
  $response = [];
  
  if (!$_SESSION['init']) {
    $response['code'] = 1;
    $response['status'] = 'Session not initialized.';
  } else {
    $id = $_SESSION['chatroom'];
    $id_meta = '.'.$id;
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
      } elseif (!isset($_GET['text'])) {
        $response['code'] = 5;
        $response['status'] = 'No message given.';
      } else {
        // prepare data
        $ip = getenv('HTTP_CLIENT_IP')?:
            getenv('HTTP_X_FORWARDED_FOR')?:
            getenv('HTTP_X_FORWARDED')?:
            getenv('HTTP_FORWARDED_FOR')?:
            getenv('HTTP_FORWARDED')?:
            getenv('REMOTE_ADDR');
        $text = str_replace(["\n", "\r", "\t"], " ", $_GET['text']);
        // write as text
        if ($metadata['mode'] == 'text') {
          $chat = fopen($id, 'a');
          flock($chat, LOCK_EX);
          fwrite($chat, microtime(true)."\t".$ip."\t".$_SESSION['username']."\t".$text."\n");
          fflush($chat);
          flock($chat, LOCK_UN);
          fclose($chat);
          $response['code'] = 0;
          $response['status'] = 'Success.';
        // write data as json
        } elseif ($metadata['mode'] == 'json') {
          //$chat = json_decode(file_get_contents($id), true);
          $chat = fopen($id, 'r+');
          flock($chat, LOCK_EX);
          $data = json_decode(fread($chat, filesize($id)), true);
          if (!isset($data) || !is_array($data)) {
            $response['code'] = 6;
            $response['status'] = 'Unable to read chat.';
          } else {
            array_push($data, ['time' => microtime(true), 'ip' => $ip, 'name' => $_SESSION['username'], 'text' => $text]);
            ftruncate($chat, 0);
            rewind($chat);
            fwrite($chat, json_encode($data));
            fflush($chat);
            $response['code'] = 0;
            $response['status'] = 'Success.';
          }
          flock($chat, LOCK_UN);
          fclose($chat);
        // write data to mysql
        } elseif ($metadata['mode'] == 'mysql') {
          
          $db_connection = new mysqli($db_server, $db_username);
          
          if ($db_connection->connect_errno) {
            $response['code'] = 7;
            $response['status'] = 'Database connection failed.';
          } else {
            $id_escape = $db_connection->real_escape_string($id);
            $text_escape = $db_connection->real_escape_string($text);
            $db_query = 'insert into Website.chat (id, stamp, ip, username, entry) values ("'.$id_escape.'", from_unixtime('.microtime(true).'), "'.$ip.'", "'.$_SESSION['username'].'", "'.$text_escape.'");';
            $db_answer = $db_connection->query($db_query);
            
            if ($db_answer) {
              // success.
              $response['code'] = 0;
              $response['status'] = 'Success.';
            } else {
              // failed.
              $response['code'] = 8;
              $response['status'] = 'Database query failed.';
            }
            if ($db_answer->free_result) {
              $db_answer->free_result();
            }
          }
          
          if ($db_connection->close) {
            $db_connection->close();
          }
        }
      }
    }
  }
  
  echo json_encode($response);
  
?>
