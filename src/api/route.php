<?php

$method = $_SERVER['REQUEST_METHOD'];

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

$config = include("../config/appconfig.php");

$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

$input = json_decode(file_get_contents('php://input'),true);

switch ($method)
{
  case 'GET':
    getRoute($_GET["routename"], $config);
    break;
  case 'PUT':
    updateRoute($input, $config );
    break;
  case 'POST':
    createRoute($input, $config );
    break;
  case 'DELETE':
    deleteRoute();
    break;
}

function getRoute($routename, $config)
{
  $filename = "../routes/".$routename;

  $handle = fopen($filename, "r") or die ("Unable to Open File");

  $contents = trim(fread($handle, filesize($filename)));

  fclose($handle);

  $routeArray = explode(",",$contents);

  updateWall($routeArray, $config);

  $jsonResponse = json_encode ( $routeArray, JSON_PRETTY_PRINT );

  /*
   * Prepare Response
   */
  header('content-type: application/json; charset=UTF-8');

  print_r ( $jsonResponse );
}

function createRoute()
{

}

function updateRoute($json, $config)
{
  global $DEBUG;

  $wallConfig  = file_get_contents("../config/wallcfg.json");

  $jsonPOS     = json_decode($wallConfig);

  $colorConfig = file_get_contents("../config/colorcfg.json");

  $jsonCOL = json_decode($colorConfig);

  $stringCommand = "sudo python3 -c \"import board, neopixel; pixels = neopixel.NeoPixel(" . $config['neoPixelPin'] . ", " . $config['neoPixelNumberOfPixels'] . ", brightness=" . $config['neoPixelBrightness'] . ");";

  foreach($json as $key=>$value)
  {
    //if($DEBUG){echo "FileName =" . $key . "<br>";}

    $key = "/routes/".$key;

    //if($DEBUG){echo "NewName =" . $key . "<br>";}

    $newValues = implode($value, ",");

    //if($DEBUG){echo "VALUES =" . $newValues . "<br>";}

    $myFile = fopen($key, "w") or die ("Unable to Open File");

    fwrite($myFile, $newValues );

    fclose($myFile);

    foreach ($value as $values)
    {
      $output = str_split($values, 2);

      $val = $output[0];

      $col = $output[1];

      $position = $jsonPOS->$val;

      $color    = $jsonCOL->$col;

      //if($DEBUG){echo "Values = " . $values . " position:" . $position . " Color = " . $color . "<br>";}

      $stringCommand .= "pixels[".$position."] = ".$color.";";
    }
  }
}

function updateWall($routeArray, $config )
{
  global $DEBUG;

  $wallConfig  = file_get_contents("../config/wallcfg.json");

  $jsonPOS     = json_decode($wallConfig);

  $colorConfig = file_get_contents("../config/colorcfg.json");

  $jsonCOL     = json_decode($colorConfig);

  $stringCommand = "sudo python3 -c \"import board, neopixel; pixels = neopixel.NeoPixel(" . $config['neoPixelPin'] . ", " . $config['neoPixelNumberOfPixels'] . ", brightness=" . $config['neoPixelBrightness'] . ");";

  foreach ($routeArray as $value)
  {

    $output = str_split($value, 2);

    $val = $output[0];

    $col = $output[1];

    $position = $jsonPOS->$val;

    $color    = $jsonCOL->$col;

    //if($DEBUG){echo "Values = " . $values . " position:" . $position . " Color = " . $color . "<br>";}

    $stringCommand .= "pixels[".$position."] = ".$color.";";
  }

  $stringCommand .= "\"";

  //if($DEBUG) {echo "$stringCommand";}

  echo `$stringCommand`;
  echo $stringCommand;
  //handling responses...
}

function deleteRoute()
{

}

?>
