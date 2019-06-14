<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1omJaibKRgHfxI9XMMnmXb-O04Zc3Wmjn');
    exit();
  }
?>
