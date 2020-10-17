<?php

class LedWallService implements ILedWallService
{
  private $_config;

  public function __construct(array $config)
  {
      $this->_config = $config;
  }

  public function wallOff(): void
  {
    $stringCommand = $this->getBaseNeoPixelCommand();

    $stringCommand .= "pixels.fill((0, 0, 0))\"";

    echo `$stringCommand`;
  }

  public function updateWall(array $routeArray): void
  {
    $stringCommand = $this->getBaseNeoPixelCommand();

    foreach ($routeArray as $hold)
    {
      $length = strlen($hold);

      $holdArray = str_split($hold, ($length-1));

      $holdPosition = $holdArray[0];

      $holdHand = $holdArray[1];

      $ledId = $this->getLedId($holdPosition);

      $ledColor = $this->getLedColor($holdHand);

      $stringCommand .= "pixels[".$ledId."] = ".$ledColor.";";
    }

    $stringCommand .= "\"";

    echo `$stringCommand`;
  }

  public function replaySequence(array $routeArray): void
  {
    $blinkArray = array();

    $stringCommand = $this->getBaseNeoPixelCommand();

    foreach ($routeArray as $hold)
    {
      $length = strlen($hold);

      $holdArray = str_split($hold, ($length-1));

      $holdPosition = $holdArray[0];

      $holdHand = $holdArray[1];

      $ledId = $this->getLedId($holdPosition);

      $ledColor = $this->getLedColor($holdHand);

      $blinkArray[$ledId] = $ledColor;

      $stringCommand .= "pixels[".$ledId."] = ".$ledColor.";";

      $stringCommand .= "time.sleep(".$this->_config["blink_delay"].");";
    }

    $stringCommand .= "\"";

    echo`$stringCommand`;
  }

  private function getLedColor(string $holdHand): string
  {
    if($holdHand == "L"){
      return $this->_config["left_hand_led_rgb"];
    }

    if($holdHand == "R"){
      return $this->_config["right_hand_led_rgb"];
    }

    if($holdHand == "M"){
      return $this->_config["match_hand_led_rgb"];
    }
  }

  private function getLedId(string $holdPosition): string
  {
    return $this->_config["led_id_map"][$holdPosition];
  }

  private function getBaseNeoPixelCommand(): string
  {
    $stringCommand = "sudo python3 -c \"import board, neopixel, time; ";
    $stringCommand .= "pixels = neopixel.NeoPixel(";
    $stringCommand .= $this->_config['neoPixelPin'];
    $stringCommand .= ", ";
    $stringCommand .= $this->_config['neoPixelNumberOfPixels'];
    $stringCommand .= ", brightness=";
    $stringCommand .= $this->_config['neoPixelBrightness'];
    $stringCommand .= ");";

    return $stringCommand;
  }
}

?>
