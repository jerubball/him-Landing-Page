<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1zLvJRtBgG_PEtpD15kF_Yc0Sob8WtrJy');
    exit();
  }
?>
