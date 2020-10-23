<?php
declare(strict_types=1);

namespace Litewall\Api;

use Litewall\LedWall\ILedWallService;
use Litewall\LedWall\RouteFileService;

final class RouteFacade
{
  private $_ledWallService;

  private $_routeFileService;

  public function __construct(ILedWallService $ledWallService, RouteFileService $routeFileService)
  {
      $this->_ledWallService = $ledWallService;
      $this->_routeFileService = $routeFileService;
  }

  public function replaySequence(string $routeName): void
  {
    if($this->_routeFileService->routeExists($routeName))
    {
      $routeArray = $this->_routeFileService->readFile($routeName);

      $this->_ledWallService->replaySequence($routeArray);
    }
  }

  public function getRoute(string $routeName): array
  {
    if (strlen($routeName) == 0) {

      $this->_ledWallService->wallOff();

      return [];
    }

    $routeArray = $this->_routeFileService->readFile($routeName);

    $this->_ledWallService->updateWall($routeArray);

    return $routeArray;
  }

  public function createRoute(string $routeName): void
  {
    $this->_routeFileService->createFile($routeName);

    $this->_ledWallService->wallOff();
  }

  public function updateRoute(array $routeUpdate): void
  {
    foreach($routeUpdate as $routeName=>$routeArray)
    {
      $this->_routeFileService->writeFile($routeName, $routeArray);

      $this->_ledWallService->updateWall($routeArray);
    }
  }

  public function deleteRoute(string $routeName): void
  {
    if($this->_routeFileService->routeExists($routeName))
    {
      $this->_routeFileService->deleteFile($routeName);
    }
  }
}
