<?php

declare(strict_types=1);

namespace Litewall\LedWall;

final class RouteFileService
{
  const BaseFilePath = "../routes/";

  public function createFile(string $routeName)
  {
    $fileKey = $this->getFileKey($routeName);

    $routeFile = fopen($fileKey, "w") or die ("Unable to Open File");

    fwrite($routeFile, "");

    fclose($routeFile);
  }

  public function readFile(string $routeName): array
  {
    if($this->routeExists($routeName))
    {
      $fileKey = $this->getFileKey($routeName);

      $handle = fopen($fileKey, "r") or die ("Unable to Open File");

      $contents = trim(fread($handle, filesize($fileKey)));

      fclose($handle);

      return explode(",",$contents);
    }
    else
    {
      return [];
    }
  }

  public function writeFile(string $routeName, array $routeArray)
  {
    $fileKey = $this->getFileKey($routeName);

    $newValues = implode($routeArray, ",");

    $routeFile = fopen($fileKey, "w") or die ("Unable to Open File");

    fwrite($routeFile, $newValues);

    fclose($routeFile);
  }

  public function deleteFile(string $routeName)
  {
    $fileKey = self::BaseFilePath . $routeName;

    unlink($fileKey);
  }

  public function routeExists(string $routeName): bool
  {
    $fileKey = $this->getFileKey($routeName);

    if(file_exists($fileKey))
    {
      if(filesize($fileKey) > 0)
      {
        return true;
      }
    }

    return false;
  }

  private function getFileKey(string $routeName): string
  {
    return self::BaseFilePath . $routeName;
  }
}