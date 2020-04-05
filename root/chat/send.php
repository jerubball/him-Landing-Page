<?php
  
  header("Content-Type: text/plain");
  
  if (!$_SESSION['init']) {
    echo '1 Session not initialized.';
  } elseif (!file_exists('.chat') || !file_exists('chat')) {
    echo '2 Chat room not found.';
  } elseif (!isset($_GET['text'])) {
    echo '3 No message given.';
  } else {
    $chat = fopen('chat', 'a');
    fwrite($chat, time()."\t".$_SERVER['REMOTE_ADDR']."\t".$_SESSION['username']."\t".$_GET['text']);
    fclose($chat);
    echo '0 Success.';
  }
  
?>