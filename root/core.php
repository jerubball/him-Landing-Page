<?php
  
  function require_https() {
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
      header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
      exit();
    }
  }
  
  define("CHARSET_NUMERIC",            0b00000001);
  define("CHARSET_ALPHABET_UPPERCASE", 0b00000010);
  define("CHARSET_ALPHABET_LOWERCASE", 0b00000100);
  define("CHARSET_ALPHABET",           0b00000110);
  define("CHARSET_ALPHANUMERIC",       0b00000111);
  define("CHARSET_UNDERSCORE",         0b00001000);
  define("CHARSET_PARENTHESES",        0b00010000);
  define("CHARSET_PUNCTUATION",        0b00100000);
  define("CHARSET_KEY_SYMBOLS",        0b01000000);
  define("CHARSET_SYMBOLS",            0b01111000);
  define("CHARSET_SPACE",              0b10000000);
  
  function random_string(int $length = 5, $charset = 0b0000111) {
    if (isset($length) && isset($charset)) {
      if (is_numeric($length) && intval($length) > 0) {
        $length = intval($length);
        
        // !"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~
        if (is_numeric($charset)) {
          $code = intval($charset);
          $charset = '';
          
          if ($code & CHARSET_NUMERIC) {
            $charset .= '0123456789';
          }
          if ($code & CHARSET_ALPHABET_UPPERCASE) {
            $charset .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          }
          if ($code & CHARSET_ALPHABET_LOWERCASE) {
            $charset .= 'abcdefghijklmnopqrstuvwxyz';
          }
          if ($code & CHARSET_UNDERSCORE) {
            $charset .= '_';
          }
          if ($code & CHARSET_PARENTHESES) {
            $charset .= '()<>[]{}';
          }
          if ($code & CHARSET_PUNCTUATION) {
            $charset .= '!"\',.:;?`';
          }
          if ($code & CHARSET_KEY_SYMBOLS) {
            $charset .= '#$%&*+-/=@\^_|~';
          }
          if ($code & CHARSET_SPACE) {
            $charset .= ' ';
          }
        }
        
        $string = '';
        $limit = (is_string($charset) ? strlen($charset) : sizeof($charset)) - 1;
        while (strlen($string) < $length) {
          $string .= $charset[rand(0, $limit)];
        }
        return $string;
        
      } else {
        return "";
      }
    } else {
      return null;
    }
  }
  
?>
