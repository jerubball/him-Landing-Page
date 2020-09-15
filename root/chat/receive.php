<?php
  
  header('Content-Type: application/json');
  
  session_start();
  
  $db_server = 'localhost';
  $db_username = 'website.local';
  
  $response = [];
  
  if (!$_SESSION['init']) {
    $response['code'] = 1;
    $response['status'] = 'Session not initialized.';
  } else {
    $id = $_SESSION['chatroom'];
    $id_meta = '.'.$id;
    $id_user = '..'.$id;
    if (!file_exists($id_meta) || !file_exists($id_user)) {
      $response['code'] = 2;
      $response['status'] = 'Chat room not found.';
    } else {
      // read metadata
      $metadata = json_decode(file_get_contents($id_meta), true);
      if (!isset($metadata) || !is_array($metadata)) {
        $response['code'] = 3;
        $response['status'] = 'Unable to read metadata.';
      } elseif (!$metadata['enabled']) { // || $metadata['expired'] || $metadata['created']
        $response['code'] = 4;
        $response['status'] = 'Chatroom expired.';
      } else {
        // update userdata
        $user = fopen($id_user, 'r+');
        flock($user, LOCK_EX);
        $userdata = json_decode(fread($user, filesize($id_user)), true);
        if (!isset($userdata) || !is_array($userdata)) {
          $response['code'] = 5;
          $response['status'] = 'Unable to read userdata.';
        } else {
          $currenttime = time();
          $expiretime = $currenttime - 5;
          $userdata[$_SESSION['username']] = $currenttime;
          // remove expired users
          foreach ($userdata as $user => $time) {
            if ($time < $expiretime) {
              unset($userdata[$user]);
            }
          }
          
          ftruncate($user, 0);
          rewind($user);
          fwrite($user, json_encode($userdata));
          fflush($user);
        }
        flock($user, LOCK_UN);
        fclose($user);
        
        // continue if no error
        if (!isset($response['code'])) {
          $_SESSION['lasttime'] = $_SESSION['timestamp'];
          $_SESSION['timestamp'] = microtime(true);
          
          $data = [];
          // read data as text
          if ($metadata['mode'] == 'text') {
            $chat = fopen($id, 'r');
            flock($chat, LOCK_SH);
            while (!feof($chat)) {
              $line = fgets($chat);
              // skip empty or commented line
              if (strlen($line) > 0 && $line[0] !== '#') {
                $items = explode("\t", $line);
                // when time was after last check
                if (sizeof($items) >= 4) {
                  $timestamp = floatval($items[0]);
                  if ($timestamp >= $_SESSION['lasttime'] && $timestamp < $_SESSION['timestamp']) {
                    // use line.
                    //array_push($data, $line);
                    // use json.
                    array_push($data, ['time' => $timestamp, 'ip' => $items[1], 'name' => $items[2], 'text' => $items[3]]);
                  }
                }
              }
            }
            flock($chat, LOCK_UN);
            fclose($chat);
            $response['code'] = 0;
            $response['status'] = 'Success.';
            $response['data'] = $data;
            $response['users'] = sizeof($userdata);
          // read data as json
          } elseif ($metadata['mode'] == 'json') {
            $chat = json_decode(file_get_contents($id, LOCK_SH), true);
            if (!isset($chat) || !is_array($chat)) {
              $response['code'] = 5;
              $response['status'] = 'Unable to read chat.';
            } else {
              $index = $_SESSION['lasttime'] == 0 ? 0 : sizeof($chat);
              while ($index > 0 && $chat[$index-1]['time'] >= $_SESSION['lasttime']) {
                $index--;
              }
              while ($index < sizeof($chat) && $chat[$index]['time'] < $_SESSION['timestamp']) {
                array_push($data, $chat[$index++]);
              }
              $response['code'] = 0;
              $response['status'] = 'Success.';
              $response['data'] = $data;
            }
          // read data from mysql
          } elseif ($metadata['mode'] == 'mysql') {
            
            $db_connection = new mysqli($db_server, $db_username);
            
            if ($db_connection->connect_errno) {
              $response['code'] = 6;
              $response['status'] = 'Database connection failed.';
            } else {
              $id_escape = $db_connection->real_escape_string($id);
              $db_query = 'select * from Website.chat where id = "'.$id_escape.'" and stamp >= from_unixtime('.$_SESSION['lasttime'].') and stamp < from_unixtime('.$_SESSION['timestamp'].');';
              $db_answer = $db_connection->query($db_query);
              
              if ($db_answer) {
                // success.
                while ($line = $db_answer->fetch_assoc()) {
                  array_push($data, ['time' => $line['stamp'], 'ip' => $line['ip'], 'name' => $line['username'], 'text' => $line['entry']]);
                }
                $response['code'] = 0;
                $response['status'] = 'Success.';
                $response['data'] = $data;
              } else {
                // failed.
                $response['code'] = 7;
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
        }
      }
    }
  }
  
  echo json_encode($response);
  
?>