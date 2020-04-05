<?php
  
  header("Content-Type: text/plain");
  
  if (!file_exists('.chat')) {
    fclose(fopen('.chat', 'w'));
  }
  if (!file_exists('chat')) {
    fclose(fopen('.chat', 'w'));
  }
  
?>
