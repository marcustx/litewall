<?php

class RouteFacade
{
  private $_ledWallService;

  private $_input;

  private $_routename;

  public function __construct($ledWallService, $input, $routename)
  {
      $this->_ledWallService = $ledWallService;
      $this->_input = $input;
      $this->_routename = $routename;
  }

  public function replaySequence()
  {
    if (strlen($this->_routename) == 0) {

      $this->_ledWallService->wallOff();

      return;
    }

    $filename = "../routes/".$this->_routename;

    if(filesize($filename) > 0)
    {
      $handle = fopen($filename, "r") or die ("Unable to Open File");

      $contents = trim(fread($handle, filesize($filename)));

      fclose($handle);

      $routeArray = explode(",",$contents);

      $this->_ledWallService->replaySequence($routeArray);
    }
    else
    {
        return;
    }
  }

  public function getRoute()
  {
    if (strlen($this->_routename) == 0) {

      $this->_ledWallService->wallOff();

      return;
    }

    $filename = "../routes/".$this->_routename;

    if(filesize($filename) > 0)
    {
      $handle = fopen($filename, "r") or die ("Unable to Open File");

      $contents = trim(fread($handle, filesize($filename)));

      fclose($handle);

      $routeArray = explode(",",$contents);

      $this->_ledWallService->updateWall($routeArray);

      $jsonResponse = json_encode ( $routeArray, JSON_PRETTY_PRINT );

      header('content-type: application/json; charset=UTF-8');

      print_r ( $jsonResponse );
    }
    else
    {
      $emptyArray = [];

      $jsonResponse = json_encode ( $emptyArray, JSON_PRETTY_PRINT );

      header('content-type: application/json; charset=UTF-8');

      print_r ( $jsonResponse );
    }
  }

  public function createRoute()
  {
    $fileKey = "../routes/".$this->_input;

    $routeFile = fopen($fileKey, "w") or die ("Unable to Open File");

    fwrite($routeFile, "");

    fclose($routeFile);

    $this->_ledWallService->wallOff();
  }

  public function updateRoute()
  {
    foreach($this->_input as $fileName=>$routeArray)
    {
      $fileKey = "../routes/".$fileName;

      $this->saveRouteFile($fileKey, $routeArray);

      $this->_ledWallService->updateWall($routeArray);
    }
  }

  public function deleteRoute()
  {
    $filekey = "../routes/".$this->_input;

    unlink($filekey);
  }

  private function saveRouteFile($fileKey, $routeArray){

    $newValues = implode($routeArray, ",");

    $routeFile = fopen($fileKey, "w") or die ("Unable to Open File");

    fwrite($routeFile, $newValues );

    fclose($routeFile);
  }
}
 ?>
