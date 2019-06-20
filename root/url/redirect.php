<?php
  $param_keys = array_keys($_GET);
  
  $db_server = 'localhost:3306';
  $db_username = 'website.local';
  $db_password = '13579';
  
  $error = false;
  
  if (sizeof($param_keys) > 0) {
    // do redirect attempt.
    $db_connection = new mysqli($db_server, $db_username, $db_password);
    
    if ($db_connection->connect_error) {
      $error = true;
      $message = 'Database connection failed.';
      //die ('Connection failed: ' . $db_connection->connect_error);
    } else {
      $url_key = $db_connection->real_escape_string($param_keys[0]);
      //$db_query = 'select * from Website.url where url = "'.$url_key.'"';
      //$db_query = 'select redirect, visited from Website.url where url = "'.$url_key.'" and (created is null or created < now()) and (expires is null or expires > now())';
      $db_query = 'select redirect, visited, (created is null or created < now()) as created, (expires is null or expires > now()) as expires from Website.url where url = "'.$url_key.'"';
      $db_answer = $db_connection->query($db_query);
      
      if ($db_answer->num_rows > 0) {
        // result found. try redirection.
        $db_array = $db_answer->fetch_assoc();
        
        if ($db_array['created'] == '0') {
          // created date is future.
          $error = true;
          $message = 'Invalid creation date.';
        } elseif ($db_array['expires'] == '0') {
          // expires date is past.
          $error = true;
          $message = 'Link is expired.';
        } else {
          // really do redirection.
          $visited = $db_array['visited'] + 1;
          
          $db_query = 'update Website.url set visited = '.$visited.' where url = "'.$url_key.'"';
          $db_connection->query($db_query);
          
          header('Location: '.$db_array['redirect']);
          exit();
        }
        
      } else {
        // result not found.
        $error = true;
        $message = 'URL not found.';
      }
      
      $db_connection->close();
    }
  }
?>

