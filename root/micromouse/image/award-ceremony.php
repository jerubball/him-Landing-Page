<?php
  $extension = '.jpg';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1B5tOWqq6i39y6xp_PxWz8qC2IJu1kaqc');
    exit();
  }
?>
