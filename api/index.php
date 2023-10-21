<?php

declare(strict_types=1);

require 'vendor/autoload.php';

require_once __DIR__ . '/src/ErrorHandler.php';

foreach (glob(__DIR__ . '/src/**/*.php') as $todasClasses) {
  require_once $todasClasses;
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$database = new Database("localhost", "projeto-faq", "root", "");

$getPath = explode("/projeto-faq-fatec/api", $_SERVER["REQUEST_URI"]);
$parts = explode("/", $getPath[1]);

if ($parts[1] == "pergunta") {
  // if (isset($parts[2]) && $parts[2] == "editar") {
  //   var_dump("editar");
  //   return;
  // }

  $gateway = new PerguntaGateway($database);
  $controller = new PerguntaController($gateway);

  $id = $parts[2] ?? null;

  $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
} elseif ($parts[1] == "usuario") {
  $gateway = new UsuarioGateway($database);
  $controller = new UsuarioController($gateway);

  if (isset($parts[2]) && $parts[2] == "ra") {
    $params =  ["ra" => $parts[3]];

    $controller->processRequest($_SERVER["REQUEST_METHOD"], $params);
    return;
  }

  if (isset($parts[2]) && $parts[2] == "email") {
    $params =  ["email" => $parts[3]];

    $controller->processRequest($_SERVER["REQUEST_METHOD"], $params);
    return;
  }

  $params = isset($parts[2]) ? ["id" => $parts[2]] : null;

  $controller->processRequest($_SERVER["REQUEST_METHOD"], $params);
} elseif ($parts[1] == "auth") {
  $gateway = new UsuarioGateway($database);
  $controller = new AuthController($gateway);

  if (isset($parts[2]) && $parts[2] == "login") {
    $controller->processRequest($_SERVER["REQUEST_METHOD"], null);
    return;
  }

  if (isset($parts[2]) && $parts[2] == "logout" && isset($parts[3])) {
    $id = $parts[3];

    $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
    return;
  }

  http_response_code(404);
  exit;
} else {
  http_response_code(404);
  exit;
}
