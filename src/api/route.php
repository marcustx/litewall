<?php

namespace Litewall\Api;

require_once __DIR__ . '/../../vendor/autoload.php';

$method = $_SERVER['REQUEST_METHOD'];

$input = json_decode(file_get_contents('php://input'),true);

$builder = new RouteFacadeBuilder();

$routeFacade = $builder->Build();

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


