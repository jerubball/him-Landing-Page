<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1K71kw_H2S-tc4YxjxnXps5Cf0RW6hpDP');
    exit();
  }
?>
