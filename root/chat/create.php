<?php
  
  header('Content-Type: application/json');
  
  $response = [];
  
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  } else {
    $id = 'chat';
  }
  
  if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
  } else {
    $mode = 'text';
  }
  
  if ($mode == 'text' || $mode == 'mysql') {
    $id_meta = '.'.$id;
    if (!file_exists($id_meta)) {
      if (touch($id_meta)) {
        
        chmod($id_meta, 0660);
        $metadata = ['mode' => $mode, 'created' => microtime(true)];
        file_put_contents($id_meta, json_encode($metadata), FILE_APPEND | LOCK_EX);
        
        if ($mode == 'text') {
          
          if (!file_exists($id)) {
            if (touch($id)) {
              chmod($id, 0660);
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
          
        } elseif ($mode == 'mysql') {
        }
        
      } else {
        $response['code'] = 3;
        $response['status'] = 'Unable to create metadata.';
      }
    } else {
      $response['code'] = 4;
      $response['status'] = 'Metadata already exists.';
    }
    
  } else { // unknown mode
    $response['code'] = 5;
    $response['status'] = 'Invalid mode.';
  }
  
  echo json_encode($response);
  
?>
