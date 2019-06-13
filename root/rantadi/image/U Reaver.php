<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1Z0H-UL-GRCCf75CiSdLT7L0DVYb1FwxT');
    exit();
  }
?>
