<?php
  $extension = '.jpg';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1hiAtnzY4_nTc7hX5Gfu9XPfpoFTFBDS3');
    exit();
  }
?>
