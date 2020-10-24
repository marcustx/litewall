<?php

namespace Litewall\Api;

use Litewall\Config\AppConfig;
use Litewall\LedWall\LedCommandBuilder;
use Litewall\LedWall\LedWallService;
use Litewall\LedWall\RouteFileService;

final class RouteFacadeBuilder
{
    public function Build()
    {
        $appConfig = new AppConfig();

        $config = $appConfig->get();

        $ledCommandBuilder = new LedCommandBuilder($config);

        $ledWallService = new LedWallService($ledCommandBuilder);

        $routeFileService = new RouteFileService();

        return new RouteFacade($ledWallService, $routeFileService, $config);
    }
}