<?php

declare(strict_types=1);

namespace Litewall\LedWall;

interface ILedWallService
{
    public function lightsOut();
    public function updateWall(array $routeArray);
}

?>
