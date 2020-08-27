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
          $chat = fopen('chat', 'a');
          flock($chat, LOCK_EX);
          fwrite($chat, microtime(true)."\t".$ip."\t".$_SESSION['username']."\t".$text."\n");
          fflush($chat);
          flock($chat, LOCK_UN);
          fclose($chat);
          $response['code'] = 0;
          $response['status'] = 'Success.';
        // write data as json
        } elseif ($metadata['mode'] == 'json') {
          $chat = json_decode(file_get_contents($id), true);
          
        // write data to mysql
        } elseif ($metadata['mode'] == 'mysql') {
        }
      }
    }
  }
  
  echo json_encode($response);
  
?>
