<?php

$method = $_SERVER['REQUEST_METHOD'];

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

$config = include("../config/appconfig.php");

$input = json_decode(file_get_contents('php://input'),true);

require_once('../litewall/ILedWallService.php');
require_once('../litewall/LedWallService.php');
require_once('RouteService.php');

$ledWallService = new LedWallService($config);

$routeService = new RouteService($ledWallService, $input, $_GET["routename"]);

switch ($method)
{
  case 'GET':
    $routeService->getRoute();
    break;
  case 'PUT':
    $routeService->updateRoute();
    break;
  case 'POST':
    $routeService->createRoute();
    break;
  case 'DELETE':
    $routeService->deleteRoute();
    break;
}

?>
