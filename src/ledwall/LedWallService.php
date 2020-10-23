<?php

declare(strict_types=1);

namespace Litewall\LedWall;

class LedWallService implements ILedWallService
{
  private $_ledCommandBuilder;

  public function __construct(LedCommandBuilder $ledCommandBuilder)
  {
      $this->_ledCommandBuilder = $ledCommandBuilder;
  }

  public function wallOff(): void
  {
    $stringCommand = $this->_ledCommandBuilder->wallOff();

    echo `$stringCommand`;
  }

  public function updateWall(array $routeArray): void
  {
    $stringCommand = $this->_ledCommandBuilder->updateWall($routeArray);

    echo `$stringCommand`;
  }

  public function replaySequence(array $routeArray): void
  {
    $stringCommand = $this->_ledCommandBuilder->replaySequence($routeArray);

    echo`$stringCommand`;
  }
}


