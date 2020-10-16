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
    $routeFacade->getRoute();
    break;
  case 'PUT':
    $routeFacade->updateRoute();
    break;
  case 'POST':
    $routeFacade->createRoute();
    break;
  case 'DELETE':
    $routeFacade->deleteRoute();
    break;
}

?>
