<?php
  
  //header('Content-Type: text/plain');
  
  session_start();
  
  if (!$_SESSION['init']) {
    $_SESSION['init'] = true;
    $_SESSION['username'] = base_convert(rand(), 10, 36);
  }
  if (isset($_GET['all']) && $_GET['all'] == 'true') {
    $_SESSION['timestamp'] = 0;
  } else {
    $_SESSION['timestamp'] = microtime(true);
  }
  
?>