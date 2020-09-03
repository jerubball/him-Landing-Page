<?php
  
  function is_email(string $email = null) {
    return isset($email) && strlen($email) > 0 && strlen($email) < 255 && preg_match('/^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z]+$/', $email);
  }
  
  function is_code(string $code = null) {
    return isset($code) && strlen($code) > 0 && strlen($code) <= 50 && preg_match('/^[a-zA-Z0-9]+$/', $code);
  }
  
?>