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
  } elseif (!isset($_GET['text'])) {
    $response['code'] = 3;
    $response['status'] = 'No message given.';
  } else {
    $ip = getenv('HTTP_CLIENT_IP')?:
        getenv('HTTP_X_FORWARDED_FOR')?:
        getenv('HTTP_X_FORWARDED')?:
        getenv('HTTP_FORWARDED_FOR')?:
        getenv('HTTP_FORWARDED')?:
        getenv('REMOTE_ADDR');
    $text = str_replace(["\n", "\r", "\t"], " ", $_GET['text']);
    $chat = fopen('chat', 'a');
    flock($chat, LOCK_EX);
    fwrite($chat, microtime(true)."\t".$ip."\t".$_SESSION['username']."\t".$text."\n");
    fflush($chat);
    flock($chat, LOCK_UN);
    fclose($chat);
    $response['code'] = 0;
    $response['status'] = 'Success.';
  }
  
  echo json_encode($response);
  
?>
