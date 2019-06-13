<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1ezoBM7eHbG9QWgsRz7Ch-hFdNOps7b0x');
    exit();
  }
?>
