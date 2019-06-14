<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1d6uG9T8G_yB8DSPDnZLieTUXE4o_fcIh');
    exit();
  }
?>
