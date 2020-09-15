<?php
  if (sizeof($_GET) > 0) {
    header('Content-Type: application/json');
  }
  
  require_once($_SERVER['DOCUMENT_ROOT'].'/core.php');
  require_once('common.php');
  
  $response = [];
  
  if (!is_email($_COOKIE['auth-email'])) {
    $response['code'] = 1;
    $response['status'] = 'Invalid email.';
  } elseif (!is_code($_COOKIE['auth-code'])) {
    $response['code'] = 2;
    $response['status'] = 'Invalid code.';
  } else {
    $db_connection = new mysqli($db_server, $db_username);
    if ($db_connection->connect_errno) {
      $response['code'] = 3;
      $response['status'] = 'Database connection failed.';
    } elseif (!$db_connection->begin_transaction(MYSQLI_TRANS_START_READ_WRITE)) {
      $response['code'] = 4;
      $response['status'] = 'Unable to start transaction.';
    } else {
      
      $email = $db_connection->real_escape_string($_COOKIE['auth-email']);
      //$token = $db_connection->real_escape_string($_COOKIE['auth-code']);
      
      // entry must exist
      $db_query = 'select email, token, now() > expires as expire, now() < suspended as suspend from Website.authentication where email = "'.$email.'";';
      $db_answer1 = $db_connection->query($db_query);
      if ($db_answer1) {
        // success.
        if ($db_answer1->num_rows > 0) {
          // has info
          $ans = $db_answer1->fetch_assoc();
          if ($ans['suspend'] && $ans['suspend'] == '1') {
            // email suspended.
            $response['code'] = 5;
            $response['status'] = 'Account is suspended for abuse.';
          } elseif ($ans['expire'] && $ans['expire'] == '1') {
            // code expired.
            $response['code'] = 6;
            $response['status'] = 'Authenticaion code has expired.';
          } elseif ($ans['token'] && $ans['token'] === $_COOKIE['auth-code']) {
            // valid entry; reset attempts
            $db_query = 'update Website.authentication set attempts = 0 where email = "'.$email.'";';
            $db_answer = $db_connection->query($db_query);
            if (!$db_answer) {
              $response['code'] = 7;
              $response['status'] = 'Database query failed.';
            }
          } else {
            // invalid entry.
            // increment attempt and suspend if needed
            $db_query = 'update Website.authentication set attempts = attempts + 1 where email = "'.$email.'";';
            $db_answer = $db_connection->query($db_query);
            if (!$db_answer) {
              $response['code'] = 8;
              $response['status'] = 'Database query failed.';
            }
            // no need to free result
            $db_query = 'update Website.authentication set suspended = adddate(now(), '.$time_suspend.'), attempts = 0 where attempts > '.$max_attempt.';';
            $db_answer = $db_connection->query($db_query);
            if (!$db_answer) {
              $response['code'] = 9;
              $response['status'] = 'Database query failed.';
            }
            // no need to free result
            
            if (!isset($response['code'])) {
              $response['code'] = -10;
              $response['status'] = 'Incorrect authentication code.';
            }
          }
        } else {
          // no info
          $response['code'] = 11;
          $response['status'] = 'No entry present.';
        }
      } else {
        // failed.
        $response['code'] = 12;
        $response['status'] = 'Database query failed.';
      }
      if ($db_answer1->free_result) {
        $db_answer1->free_result();
      }
      
      // commit if no error or negative error codes
      if (!isset($response['code']) || $response['code'] < 0) {
        if (!$db_connection->commit()) {
          $response['code'] = 13;
          $response['status'] = 'Unable to commit.';
        }
      }
      // rollback if error and positive error codes
      if (isset($response['code']) && $response['code'] > 0) {
        if (!$db_connection->rollback()) {
          $response['code'] += 100;
          $response['status'] = 'Unable to rollback.';
        }
      }
      // set success code
      if (!isset($response['code'])) {
        $response['code'] = 0;
        $response['status'] = 'Success.';
      }
    }
  }
  
  if (sizeof($_GET) > 0) {
    echo json_encode($response);
  } else {
    return $response['code'] == 0;
  }
  
?>
