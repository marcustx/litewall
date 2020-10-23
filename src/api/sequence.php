<?php

namespace Litewall\Api;

use Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

$method = $_SERVER['REQUEST_METHOD'];

$builder = new RouteFacadeBuilder();

$routeFacade = $builder->Build();

switch ($method)
{
  case 'GET':
    $routeFacade->replaySequence($_GET["routename"]);
    break;
  case 'POST':
  case 'DELETE':
  case 'PUT':
    throw new Exception("Method not yet implemented", 1);
}


