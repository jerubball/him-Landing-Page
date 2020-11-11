<?php
  //header('Content-Type: text/plain');
  
  require_once($_SERVER['DOCUMENT_ROOT'].'/core.php');
  
  session_start();
  
  if (!$_SESSION['init']) {
    $_SESSION['init'] = true;
    
    if (!isset($_SESSION['username'])) {
      if (!isset($_COOKIE['chat-username'])) {
        $_SESSION['username'] = base_convert(rand(), 10, 36);
        setcookie('chat-username', $_SESSION['username'], time() + 604800, '', '', true);
      } else {
        $_SESSION['username'] = $_COOKIE['chat-username'];
      }
    }
  }
  
  if (isset($_GET['all']) && $_GET['all'] == 'true') {
    $_SESSION['timestamp'] = 0;
  } elseif (isset($_GET['all']) && $_GET['all'] == 'false') {
    $_SESSION['timestamp'] = microtime(true);
  } elseif (isset($_COOKIE['chat-timestamp'])) {
    //$_SESSION['timestamp'] = $_COOKIE['chat-timestamp'];
    $_SESSION['timestamp'] = 0;
  } else {
    //$_SESSION['timestamp'] = microtime(true);
    $_SESSION['timestamp'] = 0;
  }
  
  $param = array_keys($_GET);
  if (sizeof($param) > 0 && file_exists('.'.$param[0])) {
    $_SESSION['chatroom'] = $param[0];
  } else {
    $_SESSION['chatroom'] = 'chat';
  }
  
?>
