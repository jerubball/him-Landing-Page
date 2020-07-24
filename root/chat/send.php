<?php
  
  header('Content-Type: text/plain');
  
  session_start();
  
  if (!$_SESSION['init']) {
    echo '1 Session not initialized.';
  } elseif (!file_exists('.chat') || !file_exists('chat')) {
    echo '2 Chat room not found.';
  } elseif (!isset($_GET['text'])) {
    echo '3 No message given.';
  } else {
    $ip = getenv('HTTP_CLIENT_IP')?:
        getenv('HTTP_X_FORWARDED_FOR')?:
        getenv('HTTP_X_FORWARDED')?:
        getenv('HTTP_FORWARDED_FOR')?:
        getenv('HTTP_FORWARDED')?:
        getenv('REMOTE_ADDR');
    $chat = fopen('chat', 'a');
    fwrite($chat, microtime(true)."\t".$ip."\t".$_SESSION['username']."\t".$_GET['text']."\n");
    fclose($chat);
    echo '0 Success.';
  }
  
?>
