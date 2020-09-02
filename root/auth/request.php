<?php
  header('Content-Type: application/json');
  
  require_once($_SERVER['DOCUMENT_ROOT'].'/core.php');
  
  $db_server = 'localhost';
  $db_username = 'website.local';
  
  $response = [];
  
  if (!isset($_GET['email']) || strlen($_GET['email']) == 0) {
    $response['code'] = 1;
    $response['status'] = 'No email provided.';
  } elseif (strlen($_GET['email']) < 255 && preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-.]+\.[a-zA-Z]+$/', $_GET['email'])) {
    $db_connection = new mysqli($db_server, $db_username);
    if ($db_connection->connect_errno) {
      $response['code'] = 2;
      $response['status'] = 'Database connection failed.';
    } elseif ($db_connection->begin_transaction(MYSQLI_TRANS_START_READ_WRITE)) {
      
      $email = $db_connection->real_escape_string($_GET['email']);
      
      // create entry if not exists
      $db_query = 'select email, unix_timestamp(suspended) as suspended, attempts from Website.authentication where email = "'.$email.'";';
      $db_answer1 = $db_connection->query($db_query);
      if ($db_answer1) {
        // success.
        if ($db_answer1->num_rows > 0) {
          // has info
          $ans = $db_answer1->fetch_assoc();
          if ($ans['suspended'] && $ans['suspended'] > time()) {
            // email suspended.
            $response['code'] = 3;
            $response['status'] = 'Account is suspended for abuse.';
          }
        } else {
          // no info
          $db_query = 'insert into Website.authentication (email) values ("'.$email.'");';
          $db_answer2 = $db_connection->query($db_query);
          if (!$db_answer2) {
            $response['code'] = 4;
            $response['status'] = 'Database query failed.';
          }
          if ($db_answer2->free_result) {
            $db_answer2->free_result();
          }
        }
      } else {
        // failed.
        $response['code'] = 5;
        $response['status'] = 'Database query failed.';
      }
      if ($db_answer1->free_result) {
        $db_answer1->free_result();
      }
      
      // increment attempt and suspend if needed
      $db_query = 'update Website.authentication set attempts = attempts + 1 where email = "'.$email.'"; update Website.authentication set suspended = adddate(now(), interval 1 week), attempts = 0 where attempts > 5;';
      $db_answer3 = $db_connection->query($db_query);
      if (!$db_answer3) {
        $response['code'] = 8;
        $response['status'] = 'Database query failed.';
      }
      if ($db_answer3->free_result) {
        $db_answer3->free_result();
      }
      
      // proceed if no error
      if (!isset($response['code'])) {
        $token = random_string();
        $subject = 'hasol.co authentication string';
        $message = <<<EOS
<!DOCTYPE html>
<html>
  <head>
    <title>$subject</title>
    <style>
      span.token {
        font-family: monospace;
        font-size: 150%;
        color: black;
        background-color: #b0b0b0;
      }
    </style>
  </head>
  <body>
    <p>
      Your hasol.co authentication string is: 
      <br>
      <span class="token">
        $token
      </span>
    </p>
  </body>
</html>
EOS;
        $header = ['From' => '"hasol.co" <him.nyit@gmail.com>', 'Reply-To' => '"hasol.co" <postmaster@hasol.co>', 'MIME-Version' => '1.0', 'Content-Type' => 'text/html', 'X-Mailer' => 'PHP/'.phpversion()];
        if (mail($_GET['email'], $subject, $message, $header)) {
          $db_query = 'update Website.authentication set token = "'.$token.'", expires = adddate(now(), interval 1 week) where email = "'.$email.'";';
          $db_answer4 = $db_connection->query($db_query);
          if (!$db_answer4) {
            $response['code'] = 6;
            $response['status'] = 'Database query failed.';
          }
          if ($db_answer4->free_result) {
            $db_answer4->free_result();
          }
        } else {
          $response['code'] = 7;
          $response['status'] = 'Unable to send email.';
        }
      }
      
      // commit if no error
      if (!isset($response['code'])) {
        if (!$db_connection->commit()) {
          $response['code'] = 9;
          $response['status'] = 'Unable to commit.';
        }
      }
      
      // rollback if error
      if (isset($response['code'])) {
        if (!$db_connection->rollback()) {
          $response['code'] = 10;
          $response['status'] = 'Unable to rollback.';
        }
      } else {
        $response['code'] = 0;
        $response['status'] = 'Success.';
      }
    } else {
      $response['code'] = 3;
      $response['status'] = 'Unable to start transaction.';
    }
    if ($db_connection->close) {
      $db_connection->close();
    }
  } else {
    $response['code'] = 3;
    $response['status'] = 'Not a vaild email.';
  }
  
  echo json_encode($response);
  
?>
