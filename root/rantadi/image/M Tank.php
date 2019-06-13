<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1tQVhmeB2b_N3wTJp7dz68kQ8UcAL8R3h');
    exit();
  }
?>
