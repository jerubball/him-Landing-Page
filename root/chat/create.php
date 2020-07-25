<?php
  
  header('Content-Type: application/json');
  
  $db_server = 'localhost';
  $db_username = 'website.local';
  
  $response = [];
  
  if (sizeof($_GET) > 0) {
    if (isset($_GET['id']) && $_GET['id'] != '') {
      $mode = '';
      if (isset($_GET['mode']) && $_GET['mode'] != '') {
        $mode = $_GET['mode'];
      } else {
        $mode = 'text';
      }
      
      
      $created = microtime(true);
      $expires = '';
      if (isset($_GET['expires']) && $_GET['expires'] != '' && is_numeric($_GET['expires'])) {
        $expires = $created + intval($_GET['expires']);
      } else {
        $expires = null;
      }
      
      if ($mode == 'text' || $mode == 'mysql') {
        // create metadata
        $id_meta = '.'.$_GET['id'];
        if (!file_exists($id_meta)) {
          if (touch($id_meta)) {
            
            chmod($id_meta, 0660);
            $metadata = ['mode' => $mode, 'enabled' => true, 'created' => $created, 'expires' => $expires];
            file_put_contents($id_meta, json_encode($metadata), FILE_APPEND | LOCK_EX);
            
            // create chat file.
            if ($mode == 'text') {
              
              if (!file_exists($_GET['id'])) {
                if (touch($_GET['id'])) {
                  chmod($_GET['id'], 0660);
                  $response['code'] = 0;
                  $response['status'] = 'Success.';
                } else {
                  $response['code'] = 1;
                  $response['status'] = 'Unable to create file.';
                }
              } else {
                $response['code'] = 2;
                $response['status'] = 'File already exists.';
              }
              
            // enter metadata for mysql.
            } elseif ($mode == 'mysql') {
              
              $db_connection = new mysqli($db_server, $db_username);
              if ($db_connection->connect_errno) {
                $response['code'] = 3;
                $response['status'] = 'Database connection failed.';
              } else {
                $id_escape = $db_connection->real_escape_string($_GET['id']);
                $db_query = 'insert into Website.chat_metadata (id, save, created, expires) values ("'.$id_escape.'", "'.$mode.'", from_unixtime('.$created.'), from_unixtime('.$expires.');';
                $db_answer = $db_connection->query($db_query);
                
                if ($db_answer) {
                  // success.
                  $response['code'] = 0;
                  $response['status'] = 'Success.';
                  $response['url'] = $url;
                } else {
                  // failed.
                  $response['code'] = 4;
                  $response['status'] = 'Database query failed.';
                }
                
              }
              $db_connection->close();
              
            }
          } else {
            $response['code'] = 5;
            $response['status'] = 'Unable to create metadata.';
          }
        } else {
          $response['code'] = 6;
          $response['status'] = 'Metadata already exists.';
        }
        
      } else { // unknown mode
        $response['code'] = 7;
        $response['status'] = 'Invalid mode.';
      }
    
    } else {
      $response['code'] = 8;
      $response['status'] = 'No id given.';
    }
  } else {
    $response['code'] = 9;
    $response['status'] = 'No parameter given.';
  }
  
  echo json_encode($response);
  
?>
