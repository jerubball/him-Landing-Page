<?php
  
  function is_email(string $email = null) {
    return isset($email) && strlen($email) > 0 && strlen($email) < 255 && preg_match('/^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z]+$/', $email);
  }
  
  function is_code(string $code = null) {
    return isset($code) && strlen($code) > 0 && strlen($code) <= 50 && preg_match('/^[a-zA-Z0-9]+$/', $code);
  }
  
  $db_server = 'localhost';
  $db_username = 'website.local';
  
  $max_attempt = '5';
  $time_suspend = 'interval 1 week';
  $time_expire = 'interval 1 week';
  $text_expire = '1 week';
  
?>
