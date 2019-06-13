<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1N_GT6udq2f7XdI74Y11jqA_y1xw_AE0O');
    exit();
  }
?>
