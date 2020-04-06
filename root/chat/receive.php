<?php
  
  header("Content-Type: text/plain");
  
  session_start();
  
  if (!$_SESSION['init']) {
    echo '1 Session not initialized.';
  } elseif (!file_exists('.chat') || !file_exists('chat')) {
    echo '2 Chat room not found.';
  } else {
    $chat = fopen('chat', 'r');
    
    fclose($chat);
  }
  
?>