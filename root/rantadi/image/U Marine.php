<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1xgYoXTV_xiPDD_BogchZ0A1dk8tV8U_Z');
    exit();
  }
?>
