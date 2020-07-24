<?php
  $db_server = 'localhost:3306';
  $db_username = 'website.local';
  $db_password = '13579';
  
  $data = [];
  
  header('Content-Type: application/json');
  
  if (sizeof($_GET) > 0) {
    if (!isset($_GET['url']) || $_GET['url'] == '') {
      $data['code'] = 1;
      $data['status'] = 'No URL given.';
    } else {
      $db_connection = new mysqli($db_server, $db_username, $db_password);
      
      if ($db_connection->connect_error) {
        $data['code'] = 2;
        $data['status'] = 'Database connection failed.';
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
          $data['code'] = 0;
          $data['status'] = 'Success.';
          $data['url'] = $url;
        } else {
          // failed.
          $data['code'] = 3;
          $data['status'] = 'Database query failed.';
        }
      }
      
      $db_connection->close();
    }
  } else {
    $data['code'] = 4;
    $data['status'] = 'No parameter given.';
  }
  
  echo json_encode($data);
?>
