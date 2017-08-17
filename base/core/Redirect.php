<?php namespace Snipe\Core;

class Redirect {

    public static function to($location = null) {
      if (!is_null($location)){

          $pos = strpos($location, 'http');
          $posS = strpos($location, 'https');

          if ($pos !== false || $posS !== false) {
              header('Location: ' . $location);
              exit();
          }

          if (is_numeric($location)) {
              switch ($location) {
                  case 404:
                      header('HTTP/1.0 404 Not Found');
                      include Path::to('app') .DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'404.php';
                      exit();
                  break;
              }
          }
          header('Location: ' . URL::to($location));
          exit();
      }
    }

}
