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
        $expires_sql = $expires;
      } else {
        $expires = null;
        $expires_sql = 'null';
      }
      
      if ($mode == 'text' || $mode == 'json' || $mode == 'mysql') {
        // create metadata
        $id = $_GET['id'];
        $id_meta = '.'.$id;
        if (!file_exists($id_meta)) {
          if (touch($id_meta)) {
            
            chmod($id_meta, 0660);
            $metadata = ['name' => $id, 'mode' => $mode, 'enabled' => true, 'created' => $created, 'expires' => $expires];
            file_put_contents($id_meta, json_encode($metadata), FILE_APPEND | LOCK_EX);
            
            // create userdata
            $id_user = '..'.$id;
            if (!file_exists($id_user)) {
              if (touch($id_user)) {
                
                chmod($id_user, 0660);
                file_put_contents($id_user, json_encode([]));
                
                // create chat file.
                if ($mode == 'text' || $mode == 'json') {
                  
                  if (!file_exists($id)) {
                    if (touch($id)) {
                      chmod($id, 0660);
                      if ($mode == 'json') {
                        file_put_contents($id, json_encode([]));
                      }
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
                    $id_escape = $db_connection->real_escape_string($id);
                    $db_query = 'insert into Website.chat_metadata (id, save, created, expires) values ("'.$id_escape.'", "'.$mode.'", from_unixtime('.$created.'), from_unixtime('.$expires_sql.'));';
                    $db_answer = $db_connection->query($db_query);
                    
                    if ($db_answer) {
                      // success.
                      $response['code'] = 0;
                      $response['status'] = 'Success.';
                    } else {
                      // failed.
                      $response['code'] = 4;
                      $response['status'] = 'Database query failed.';
                    }
                    if ($db_answer->free_result) {
                      $db_answer->free_result();
                    }
                  }
                  
                  if ($db_connection->close) {
                    $db_connection->close();
                  }
                }
                
              } else {
                $response['code'] = 5;
                $response['status'] = 'Unable to create userdata.';
              }
            } else {
              $response['code'] = 6;
              $response['status'] = 'Userdata already exists.';
            }
          } else {
            $response['code'] = 7;
            $response['status'] = 'Unable to create metadata.';
          }
        } else {
          $response['code'] = 8;
          $response['status'] = 'Metadata already exists.';
        }
        
      } else { // unknown mode
        $response['code'] = 9;
        $response['status'] = 'Invalid mode.';
      }
    
    } else {
      $response['code'] = 10;
      $response['status'] = 'No id given.';
    }
  } else {
    $response['code'] = 11;
    $response['status'] = 'No parameter given.';
  }
  
  echo json_encode($response);
  
?>
