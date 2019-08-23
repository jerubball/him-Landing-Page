<?php
  $extension = '.jpg';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1RWzlM9E9WdFIYvRGMrz9Hj-Zhf2hphwW');
    exit();
  }
?>
