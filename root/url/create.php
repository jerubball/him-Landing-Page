<?php
  $db_server = 'localhost';
  $db_username = 'website.local';
  
  $response = [];
  
  header('Content-Type: application/json');
  
  if (sizeof($_GET) > 0) {
    if (!isset($_GET['url']) || $_GET['url'] == '') {
      $response['code'] = 1;
      $response['status'] = 'No URL given.';
    } else {
      $db_connection = new mysqli($db_server, $db_username);
      
      if ($db_connection->connect_errno) {
        $response['code'] = 2;
        $response['status'] = 'Database connection failed.';
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
        
        // insert into responsebase.
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
          $response['code'] = 0;
          $response['status'] = 'Success.';
          $response['url'] = $url;
        } else {
          // failed.
          $response['code'] = 3;
          $response['status'] = 'Database query failed.';
        }
      }
      
      $db_connection->close();
    }
  } else {
    $response['code'] = 4;
    $response['status'] = 'No parameter given.';
  }
  
  echo json_encode($response);
?>
