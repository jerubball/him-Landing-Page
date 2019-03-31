<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="google-site-verification" content="w1ig7tmYsNZOx3NG3Tl9Z7Qjhnr4SCSP5hj2PHQyp0Q" />
  <!-- Bootstrap CDN -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-124973345-1"></script>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137014432-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-124973345-1');
    gtag('config', 'UA-137014432-1');
  </script>
  <!-- Global tag -->
  <title>Landing Page</title>
  <link rel="shortcut icon" href="/favicon-alt.ico">
  <link rel="stylesheet" href="/wireframe.css">
  <script src="/core.js"></script>
</head>

<body onload="setTitle('Landing Page')">
<?php
  include 'test.php';
?>
  <nav class="navbar navbar-expand-md bg-secondary navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="/">NYIT-him</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="https://">This Site</a>
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
          <h1 class="display-3">Landing Page</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="p-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="">Go To's</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <ul class="">
            <li>
              <h2 class="">
                <a href="/TrackingSystem/">Go to Tracking System Application</a>
              </h2>
            </li>
            <li>
              <h2 class="">
                <a href="/rantadi/">Go to 랜타디 reference sheet</a>
              </h2>
            </li>
            <li>
              <h2 class="">
                <a href="/scripts/">Go to Linux bash scripts</a>
              </h2>
            </li>
            <li>
              <h2 class="">
                <a href="/time/">Go to Time application</a>
                <a href="/time/help.html">(Help topic)</a>
              </h2>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="p-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="">HTTP/HTTPS</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <ul class="">
            <li>
              <h2 class="">
                <a href="#" onclick="setProtocol('http:')">Use HTTP.</a>
              </h2>
            </li>
            <li>
              <h2 class="">
                <a href="#" onclick="setProtocol('https:')">Use HTTPS.</a>
              </h2>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="p-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="">About</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <p class="lead"> Welcome to him's website.
            <br> This locally hosted website contains other sub-websites, which can be found above.
            <br>
            <br> Free domain service provided by
            <a href="https://www.noip.com">no-ip.com</a>.
            <br> Web service powered by
            <a href="https://httpd.apache.org">Apache HTTP Server Project</a>.
            <br> SSL certificate generated by
            <a href="https://www.sslforfree.com">SSL For Free</a>.
            <br> Server machine running with
            <a href="https://kubuntu.org">Kubuntu 18.04</a>.
            <br> Website design made with
            <a href="https://pingendo.com">Pingendo Free</a>.
            <br> </p>
        </div>
      </div>
    </div>
  </div>
  <div class="p-2">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="">Contact me</h2>
          <ul>
            <li>
              <a href="mailto:him.nyit@gmail.com">him.nyit@gmail.com</a>
            </li>
            <li>
              <a href="mailto:him@nyit.edu">him@nyit.edu</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
