<?php namespace Snipe\Core;

class URL {

    public static function to($normalpath) {
      if($normalpath == '/'){
        return ((isset($_SERVER['HTTPS']))?'https':'http').'://' . $_SERVER['HTTP_HOST'] . str_replace('/index.php', '', $_SERVER['PHP_SELF']) . '/';
      }

      return ((isset($_SERVER['HTTPS']))?'https':'http').'://' . $_SERVER['HTTP_HOST'] . str_replace('/index.php', '', $_SERVER['PHP_SELF']) . '/' . $normalpath;
    }
}
