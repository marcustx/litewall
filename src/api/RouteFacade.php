<?php
declare(strict_types=1);

namespace Litewall\Api;

use Litewall\Config\AppConfig;
use Litewall\LedWall\ILedWallService;
use Litewall\LedWall\RouteFileService;
use Litewall\LedWall\RouteValidator;
use Exception;

final class RouteFacade
{
    private $_ledWallService;

    private $_routeFileService;

    private $_appConfig;

    private $_routeValidator;

    public function __construct(ILedWallService $ledWallService, RouteFileService $routeFileService, array $appConfig)
    {
        $this->_ledWallService = $ledWallService;
        $this->_routeFileService = $routeFileService;
        $this->_appConfig = $appConfig;
        $this->_routeValidator = new RouteValidator($appConfig);
    }

    public function replaySequence(string $routeName): void
    {
        if ($this->_routeFileService->routeExists($routeName)) {
            $routeArray = $this->_routeFileService->readFile($routeName);

            $this->_ledWallService->replaySequence($routeArray);
        }
    }

    public function getRoute(string $routeName): array
    {
        if (strlen($routeName) == 0) {

            $this->_ledWallService->lightsOut();

            return [];
        }

        $routeArray = $this->_routeFileService->readFile($routeName);

        $this->_ledWallService->updateWall($routeArray);

        return $routeArray;
    }

    public function createRoute(string $routeName): void
    {
        $this->_routeFileService->createFile($routeName);

        $this->_ledWallService->lightsOut();
    }

    public function updateRoute(array $routeUpdate): void
    {
        foreach ($routeUpdate as $routeName => $routeArray) {
            if ($this->_routeValidator->isValidRoute($routeArray)) {
                $this->_routeFileService->writeFile($routeName, $routeArray);

                $this->_ledWallService->updateWall($routeArray);
            } else {
                throw new Exception("Route value is not valid");
            }
        }
    }

    public function deleteRoute(string $routeName): void
    {
        if ($this->_routeFileService->routeExists($routeName)) {
            $this->_routeFileService->deleteFile($routeName);
        }
    }
}
