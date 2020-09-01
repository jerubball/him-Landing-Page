<?php
  header('Content-Type: application/json');
  
  require_once($_SERVER['DOCUMENT_ROOT'].'/core.php');
  
  $db_server = 'localhost';
  $db_username = 'website.local';
  
  if (isset($_GET['email']) && strlen($_GET['email']) > 0 && preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-.]+\.[a-zA-Z]+$/', $_GET['email'])) {
    mail($_GET['email'], 'hasol.co authentication string', random_string());
  }
  
?>
