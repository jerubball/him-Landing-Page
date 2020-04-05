<?php
  
  header("Content-Type: text/plain");
  
  if (!file_exists('.chat')) {
    fclose(fopen('.chat', 'w'));
    echo 'metadata created.';
  } else {
    echo 'metadata exists.';
  }
  echo "\r\n";
  if (!file_exists('chat')) {
    fclose(fopen('.chat', 'w'));
    echo 'file created.';
  } else {
    echo 'file exists.';
  }
  
?>
