<?php
  //header('Content-Type: text/plain');
  
  require_once($_SERVER['DOCUMENT_ROOT'].'/core.php');
  
  session_start();
  
  if (!$_SESSION['init']) {
    $_SESSION['init'] = true;
    
    if (!isset($_SESSION['username'])) {
      $_SESSION['username'] = base_convert(rand(), 10, 36);
      setcookie('chat-username', $_SESSION['username'], time() + 604800, '', '', true);
    }
  }
  
  if (isset($_GET['all']) && $_GET['all'] == 'true') {
    $_SESSION['timestamp'] = 0;
  } else {
    $_SESSION['timestamp'] = microtime(true);
  }
  
  $param = array_keys($_GET);
  if (sizeof($param) > 0 && file_exists('.'.$param[0])) {
    $_SESSION['chatroom'] = $param[0];
  } else {
    $_SESSION['chatroom'] = 'chat';
  }
  
?>