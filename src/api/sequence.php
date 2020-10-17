<?php

$method = $_SERVER['REQUEST_METHOD'];

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

$config = include("../config/appconfig.php");

$input = json_decode(file_get_contents('php://input'),true);

require_once('../litewall/ILedWallService.php');
require_once('../litewall/LedWallService.php');
require_once('../litewall/RouteFileService.php');
require_once('RouteFacade.php');

$ledWallService = new LedWallService($config);

$routeFileService = new RouteFileService();

$routeFacade = new RouteFacade($ledWallService, $routeFileService);

switch ($method)
{
  case 'GET':
    $routeFacade->replaySequence($_GET["routename"]);
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
