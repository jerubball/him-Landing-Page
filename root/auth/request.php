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
    $token = random_string();
    $subject = 'hasol.co authentication string';
    $message = '<html><head><title>'.$subject.'</title></head> <body>Your hasol.co authentication string is <a style="font-family:monospace">'.$token.'</a></body></html>';
    $header = ['From' => 'www-data@hasol.co', 'Reply-To' => 'www-data@hasol.co', 'MIME-Version' => '1.0', 'Content-Type' => 'text/html', 'X-Mailer' => 'PHP/'.phpversion()];
    if (mail($_GET['email'], $subject, $message, $header)) {
      
      $response['code'] = 0;
      $response['status'] = 'Success.';
    } else {
      $response['code'] = 2;
      $response['status'] = 'Unable to send email.';
    }
  } else {
    $response['code'] = 3;
    $response['status'] = 'Not a vaild email.';
  }
  
  echo json_encode($response);
  
?>
