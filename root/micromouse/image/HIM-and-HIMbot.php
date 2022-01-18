<?php
  $extension = '.jpg';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1dlSR_iuB0V6ndrALdz_RNFBwN59NUKmJ');
    exit();
  }
?>
