<?php
  
  header("Content-Type: text/plain");
  
  if (!file_exists('.chat')) {
    touch('.chat');
    echo 'metadata created.';
  } else {
    echo 'metadata exists.';
  }
  echo "\r\n";
  if (!file_exists('chat')) {
    touch('chat');
    echo 'file created.';
  } else {
    echo 'file exists.';
  }
  
?>
