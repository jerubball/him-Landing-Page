<?php
  
  header("Content-Type: text/plain");
  
  session_start();
  
  if (!$_SESSION['init']) {
    echo '1 Session not initialized.';
  } elseif (!file_exists('.chat') || !file_exists('chat')) {
    echo '2 Chat room not found.';
  } elseif (!isset($_GET['text'])) {
    echo '3 No message given.';
  } else {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $chat = fopen('chat', 'a');
    fwrite($chat, time()."\t".$ip."\t".$_SESSION['username']."\t".$_GET['text']."\n");
    fclose($chat);
    echo '0 Success.';
  }
  
?>
