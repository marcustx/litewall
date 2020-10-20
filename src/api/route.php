<?php
use Litewall\ledwall\LedCommandBuilder;
$method = $_SERVER['REQUEST_METHOD'];

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

$config = include("../config/appconfig.php");

$input = json_decode(file_get_contents('php://input'),true);

require_once('../ledwall/ILedWallService.php');
require_once('../ledwall/LedWallService.php');
require_once('../ledwall/RouteFileService.php');
require_once('../ledwall/LedCommandBuilder.php');
require_once('RouteFacade.php');

$ledCommandBuilder = new LedCommandBuilder($config);

$ledWallService = new LedWallService($ledCommandBuilder);

$routeFileService = new RouteFileService();

$routeFacade = new RouteFacade($ledWallService, $routeFileService);

switch ($method)
{
  case 'GET':
    $routeArray = $routeFacade->getRoute($_GET["routename"]);

    $jsonResponse = json_encode ( $routeArray, JSON_PRETTY_PRINT );

    header('content-type: application/json; charset=UTF-8');

    print_r ( $jsonResponse );

    break;
  case 'PUT':
    $routeFacade->updateRoute($input);
    break;
  case 'POST':
    $routeFacade->createRoute($input);
    break;
  case 'DELETE':
    $routeFacade->deleteRoute($input);
    break;
}

?>
