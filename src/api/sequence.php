<?php

$method = $_SERVER['REQUEST_METHOD'];

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

$config = include("../config/appconfig.php");

$input = json_decode(file_get_contents('php://input'),true);

require_once('../litewall/ILedWallService.php');
require_once('../litewall/LedWallService.php');
require_once('RouteFacade.php');

$ledWallService = new LedWallService($config);

$routeFacade = new RouteFacade($ledWallService, $input, $_GET["routename"]);

switch ($method)
{
  case 'GET':
    $routeFacade->replaySequence();
    break;
  case 'PUT':
    throw new Exception("Method not yet implemented", 1);
    break;
  case 'POST':
    throw new Exception("Method not yet implemented", 1);
    break;
  case 'DELETE':
    throw new Exception("Method not yet implemented", 1);
    break;
}

?>
