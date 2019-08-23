<?php
  $extension = '.jpg';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1XQ1n19xFLwz6Rf5X4jqp0xQzQaHgNoSO');
    exit();
  }
?>
