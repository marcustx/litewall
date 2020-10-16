<?php

class LedWallService implements ILedWallService
{
  private $_config;

  public function __construct($config)
  {
      $this->_config = $config;
  }

  public function wallOff(){
    $stringCommand = $this->getBaseNeoPixelCommand();

    $stringCommand .= "pixels.fill((0, 0, 0))\"";

    echo `$stringCommand`;
  }

  public function updateWall($routeArray)
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

    // $this->replaySequence($routeArray);

    echo `$stringCommand`;
  }

  private function replaySequence($routeArray)
  {
    $blinkArray = array();

    foreach ($routeArray as $hold)
    {
      $length = strlen($hold);

      $holdArray = str_split($hold, ($length-1));

      $holdPosition = $holdArray[0];

      $holdHand = $holdArray[1];

      $ledId = $this->getLedId($holdPosition);

      $ledColor = $this->getLedColor($holdHand);

      $blinkArray[$ledId] = $ledColor;
    }

    //very roughly stubbed.  probably wrong
    $stringCommand = "sudo echo ";
    $stringCommand .= json_encode($blinkArray);
    $stringCommand .= " python3 blink.py";

    echo`$stringCommand`;
  }

  private function getLedColor($holdHand)
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

  private function getLedId($holdPosition){
    return $this->_config["led_id_map"][$holdPosition];
  }

  private function getBaseNeoPixelCommand(){
    $stringCommand = "sudo python3 -c \"import board, neopixel; ";
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
