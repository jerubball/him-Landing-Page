<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1EFtkKcIkaTLaYqhX8r1CbR-D43QW2vZU');
    exit();
  }
?>
