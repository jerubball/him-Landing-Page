<?php
  $extension = '.jpg';
  $filename = basename(__FILE__, '.php').$extension;
  if (file_exists($filename)) {
    header('Location: '.$filename);
    exit();
  } else {
    header('Location: https://drive.google.com/uc?export=view&id=1U1Ca9tF8SI8LDZ7cPqUHt8Vn_K-GA1wD');
    exit();
  }
?>
