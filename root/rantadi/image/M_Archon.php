<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=12vCWa56slZJQHK1EHDF4i49OVTKwr0Mt');
    exit();
  }
?>
