<?php
use Litewall\ledwall\LedCommandBuilder;

class LedWallService implements ILedWallService
{
  private $_ledCommandBuilder;

  public function __construct(Litewall\ledwall\LedCommandBuilder $ledCommandBuilder)
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

?>
