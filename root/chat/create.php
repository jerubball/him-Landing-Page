<?php
  
  header('Content-Type: text/plain');
  
  if (!file_exists('.chat')) {
    if (touch('.chat')) {
      chmod('.chat', 0660);
      echo 'metadata created.';
    } else {
      echo 'unable to create metadata.';
    }
  } else {
    echo 'metadata exists.';
  }
  echo "\r\n";
  if (!file_exists('chat')) {
    if (touch('chat')) {
      chmod('chat', 0660);
      echo 'file created.';
    } else {
      echo 'unable to create file.';
    }
  } else {
    echo 'file exists.';
  }
  
?>
