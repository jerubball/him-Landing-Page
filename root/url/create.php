<?php
  $db_server = 'localhost:3306';
  $db_username = 'website.local';
  $db_password = '13579';
  
  $error = false;
  
  header("Content-Type: text/plain");
  
  if (sizeof($_GET) > 0) {
    if (!isset($_GET['url']) || $_GET['url'] == '') {
      $error = true;
      $message = 'No URL given.';
    } else {
      $db_connection = new mysqli($db_server, $db_username, $db_password);
      
      if ($db_connection->connect_error) {
        $error = true;
        $message = 'Database connection failed.';
        //die ('Connection failed: ' . $db_connection->connect_error);
      } else {
        $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_';
        $charsize = strlen($charset) - 1;
        
        $url = '';
        $pass = false;
        $length = 5;
        
        while (!$pass) {
          for ($url = ''; strlen($url) < $length;) {
            $url .= $charset[rand(0, $charsize)];
          }
          
          // check if generated url is never used.
          $db_query = 'select * from Website.url where url = "'.$url.'"';
          $db_answer = $db_connection->query($db_query);
      
          if ($db_answer->num_rows > 0) {
            // failed attempt. generate longer url.
            $length += 1;
          } else {
            // success. continue.
            $pass = true;
          }
        }
        
        // insert into database.
        $redirect = $db_connection->real_escape_string($_GET['url']);
        $expires = '';
        if (!isset($_GET['expires']) || $_GET['expires'] == '') {
          $expires = 'null';
        } else {
          $expires = 'date_add(now(), interval '.$db_connection->real_escape_string($_GET['expires']).')';
        }
        $db_query = 'insert into Website.url (url, redirect, created, expires) values ("'.$url.'", "'.$redirect.'", now(), '.$expires.');';
        $db_answer = $db_connection->query($db_query);
        
        if ($db_answer) {
          // success.
          $message = $url;
        } else {
          // failed.
          $error = true;
          $message = 'Database query failed.';
        }
      }
      
      $db_connection->close();
    }
  } else {
    $error = true;
    $message = 'No parameter given.';
  }
  
  if ($error) {
    echo 1;
  } else {
    echo 0;
  }
  echo ' '.$message;
?>
