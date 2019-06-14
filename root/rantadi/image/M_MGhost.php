<?php
  $extension = '.png';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1vZ3OehdwZ1vsFIFQB9wQK4x6IxotxhO5');
    exit();
  }
?>
