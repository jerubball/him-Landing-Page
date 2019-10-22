<?php
  $extension = '.jpg';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1V64rbWy3WLLPro9wDrY6bbxHu0RKQTzn');
    exit();
  }
?>
