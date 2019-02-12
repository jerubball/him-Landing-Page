<?php
  $code = isset($_GET["code"]) ? $_GET["code"] : $code = "";
  switch ($code) {
    case "100":
      $status = $code." Continue";
      $style = "text-info";
      break;
    case "101":
      $status = $code." Switching Protocols";
      $style = "text-info";
      break;
    case "102":
      $status = $code." Processing";
      $style = "text-info";
      break;
    case "103":
      $status = $code." Early Hints";
      $style = "text-info";
      break;
    case "200":
      $status = $code." OK";
      $style = "text-success";
      break;
    case "201":
      $status = $code." Created";
      $style = "text-success";
      break;
    case "202":
      $status = $code." Accepted";
      $style = "text-success";
      break;
    case "203":
      $status = $code." Non-Authoritative Information";
      $style = "text-success";
      break;
    case "204":
      $status = $code." No Content";
      $style = "text-success";
      break;
    case "205":
      $status = $code." Reset Content";
      $style = "text-success";
      break;
    case "206":
      $status = $code." Partial Content";
      $style = "text-success";
      break;
    case "207":
      $status = $code." Multi-Status";
      $style = "text-success";
      break;
    case "208":
      $status = $code." Already Reported";
      $style = "text-success";
      break;
    case "218":
      $status = $code." This is fine";
      $style = "text-success";
      break;
    case "226":
      $status = $code." IM Used";
      $style = "text-success";
      break;
    case "300":
      $status = $code." Multiple Choices";
      $style = "text-warning";
      break;
    case "301":
      $status = $code." Moved Permanently";
      $style = "text-warning";
      break;
    case "302":
      $status = $code." Found";
      $style = "text-warning";
      break;
    case "303":
      $status = $code." See Other";
      $style = "text-warning";
      break;
    case "304":
      $status = $code." Not Modified";
      $style = "text-warning";
      break;
    case "305":
      $status = $code." Use Proxy";
      $style = "text-warning";
      break;
    case "306":
      $status = $code." Switch Proxy";
      $style = "text-warning";
      break;
    case "307":
      $status = $code." Temporary Redirect";
      $style = "text-warning";
      break;
    case "308":
      $status = $code." Permanent Redirect";
      $style = "text-warning";
      break;
    case "400":
      $status = $code." Bad Request";
      $style = "text-danger";
      break;
    case "401":
      $status = $code." Unauthorized";
      $style = "text-danger";
      break;
    case "402":
      $status = $code." Payment Required";
      $style = "text-danger";
      break;
    case "403":
      $status = $code." Forbidden";
      $style = "text-danger";
      break;
    case "404":
      $status = $code." Not Found";
      $style = "text-danger";
      break;
    case "405":
      $status = $code." Method Not Allowed";
      $style = "text-danger";
      break;
    case "406":
      $status = $code." Not Acceptable";
      $style = "text-danger";
      break;
    case "407":
      $status = $code." Proxy Authentication Required";
      $style = "text-danger";
      break;
    case "408":
      $status = $code." Request Timeout";
      $style = "text-danger";
      break;
    case "409":
      $status = $code." Conflict";
      $style = "text-danger";
      break;
    case "410":
      $status = $code." Gone";
      $style = "text-danger";
      break;
    case "411":
      $status = $code." Length Required";
      $style = "text-danger";
      break;
    case "412":
      $status = $code." Precondition Failed";
      $style = "text-danger";
      break;
    case "413":
      $status = $code." Payload Too Large";
      $style = "text-danger";
      break;
    case "414":
      $status = $code." URI Too Long";
      $style = "text-danger";
      break;
    case "415":
      $status = $code." Unsupported Media Type";
      $style = "text-danger";
      break;
    case "416":
      $status = $code." Range Not Satisfiable";
      $style = "text-danger";
      break;
    case "417":
      $status = $code." Expectation Failed";
      $style = "text-danger";
      break;
    case "418":
      $status = $code." I'm a teapot";
      $style = "text-muted";
      break;
    case "421":
      $status = $code." Misdirected Request";
      $style = "text-danger";
      break;
    case "422":
      $status = $code." Unprocessable Entity";
      $style = "text-danger";
      break;
    case "423":
      $status = $code." Locked";
      $style = "text-danger";
      break;
    case "424":
      $status = $code." Failed Dependency";
      $style = "text-danger";
      break;
    case "426":
      $status = $code." Upgrade Required";
      $style = "text-danger";
      break;
    case "428":
      $status = $code." Precondition Required";
      $style = "text-danger";
      break;
    case "429":
      $status = $code." Too Many Requests";
      $style = "text-danger";
      break;
    case "431":
      $status = $code." Request Header Fields Too Large";
      $style = "text-danger";
      break;
    case "451":
      $status = $code." Unavailable For Legal Reasons";
      $style = "text-danger";
      break;
    case "500":
      $status = $code." Internal Server Error";
      $style = "text-danger";
      break;
    case "501":
      $status = $code." Not Implemented";
      $style = "text-danger";
      break;
    case "502":
      $status = $code." Bad Gateway";
      $style = "text-danger";
      break;
    case "503":
      $status = $code." Service Unavailable";
      $style = "text-danger";
      break;
    case "504":
      $status = $code." Gateway Timeout";
      $style = "text-danger";
      break;
    case "505":
      $status = $code." HTTP Version Not Supported";
      $style = "text-danger";
      break;
    case "506":
      $status = $code." Variant Also Negotiates";
      $style = "text-danger";
      break;
    case "507":
      $status = $code." Insufficient Storage";
      $style = "text-danger";
      break;
    case "508":
      $status = $code." Loop Detected";
      $style = "text-danger";
      break;
    case "509":
      $status = $code." Bandwidth Limit Exceeded";
      $style = "text-danger";
      break;
    case "510":
      $status = $code." Not Extended";
      $style = "text-danger";
      break;
    case "511":
      $status = $code." Network Authentication Required";
      $style = "text-danger";
      break;
    default:
      $status = "Error";
      $style = "text-primary";
      break;
  }
?>

<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://him-nyit.ddns.net/wireframe.css">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-124973345-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-124973345-1');
  </script>
  <title><?php echo $status; ?></title>
</head>

<body>
  <nav class="navbar navbar-expand-md bg-secondary navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="/">NYIT-him</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="https://him-nyit.ddns.net/">This Site</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ftp://him-nyit.ddns.net/">FTP Site</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://sites.nyit.edu/him/home">Google Sites</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://github.com/jerubball">GitHub</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="https://www.nyit.edu/">NYIT</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="mailto:him.nyit@gmail.com">Contact me</a>
          </li>
        </ul>
        <form class="form-inline m-0">
          <input class="form-control mr-2" type="text" placeholder="Search">
          <button class="btn btn-primary" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <div class="p-4">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="display-1 font-italic <?php echo $style; ?>"><?php echo $status; ?></h1>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
