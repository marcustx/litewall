<?php

class RouteFileService
{
  const BaseFilePath = "../routes/";

  public function createFile(string $routeName)
  {
    $fileKey = $this->getFilekey($routeName);

    $routeFile = fopen($fileKey, "w") or die ("Unable to Open File");

    fwrite($routeFile, "");

    fclose($routeFile);
  }

  public function readFile(string $routeName): array
  {
    if($this->routeExists($routeName))
    {
      $fileKey = $this->getFilekey($routeName);

      $handle = fopen($fileKey, "r") or die ("Unable to Open File");

      $contents = trim(fread($handle, filesize($fileKey)));

      fclose($handle);

      return explode(",",$contents);
    }
    else
    {
      $emptyArray = [];

      return $emptyArray;
    }
  }

  public function writeFile(string $routeName, array $routeArray)
  {
    $fileKey = $this->getFilekey($routeName);

    $newValues = implode($routeArray, ",");

    $routeFile = fopen($fileKey, "w") or die ("Unable to Open File");

    fwrite($routeFile, $newValues);

    fclose($routeFile);
  }

  public function deleteFile(string $routeName)
  {
    $filekey = self::BaseFilePath . $routeName;

    unlink($filekey);
  }

  public function routeExists(string $routeName): bool
  {
    $filekey = $this->getFilekey($routeName);

    if(file_exists($filekey))
    {
      if(filesize($filekey) > 0)
      {
        return true;
      }
    }

    return false;
  }

  private function getFilekey(string $routeName): string
  {
    $key = self::BaseFilePath . $routeName;

    return $key;
  }
}

?>
