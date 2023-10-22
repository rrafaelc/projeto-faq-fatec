<?php

declare(strict_types=1);

require_once __DIR__ . '/src/ErrorHandler.php';

require 'vendor/autoload.php';
require 'config.php';

foreach (glob(__DIR__ . '/src/**/*.php') as $todasClasses) {
  require_once $todasClasses;
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$config = [
  "secret_key" => $_ENV["JWT_KEY"],
  "iat" => $iat,
  "access_token_expiration" => $access_token_expiration,
  "refresh_token_expiration" => $refresh_token_expiration,
];

$database = new Database("localhost", "projeto-faq", "root", "");

$getPath = explode("/projeto-faq-fatec/api", $_SERVER["REQUEST_URI"]);
$parts = explode("/", $getPath[1]);

$token = getBearerToken();

$usuarioGateway = new UsuarioGateway($database);
$authController = new AuthController($usuarioGateway, $config);

if ($parts[1] == "pergunta") {
  // if (isset($parts[2]) && $parts[2] == "editar") {
  //   var_dump("editar");
  //   return;
  // }

  $perguntaGateway = new PerguntaGateway($database);
  $controller = new PerguntaController($perguntaGateway, $config, $authController, $token);

  $id = $parts[2] ?? null;

  $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
} elseif ($parts[1] == "usuario") {
  $gateway = new UsuarioGateway($database);
  $controller = new UsuarioController($gateway, $config, $authController, $token);

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

  if (isset($parts[2]) && $parts[2] == "refresh_token") {
    $authController->processRequest($_SERVER["REQUEST_METHOD"], true);
    return;
  }

  if (isset($parts[2]) && $parts[2] == "login") {
    $authController->processRequest($_SERVER["REQUEST_METHOD"]);
    return;
  }

  if (isset($parts[2]) && $parts[2] == "logout") {
    $authController->logout($_SERVER["REQUEST_METHOD"], $config, $token);
    return;
  }

  http_response_code(404);
  exit;
} else {
  http_response_code(404);
  exit;
}
