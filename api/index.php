<?php

declare(strict_types=1);

// spl_autoload_register(function ($class) {
//   require __DIR__ . "/src/$class.php";
// });

require_once __DIR__ . '/src/ErrorHandler.php';

foreach (glob(__DIR__ . '/src/**/*.php') as $todasClasses) {
  require_once $todasClasses;
}

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$database = new Database("localhost", "projeto-faq", "root", "");

$getPath = explode("/projeto-faq-fatec/api", $_SERVER["REQUEST_URI"]);
$parts = explode("/", $getPath[1]);

if ($parts[1] == "perguntas") {
  if (isset($parts[2]) && $parts[2] == "editar") {
    var_dump("editar");
    return;
  }

  $gateway = new PerguntaGateway($database);
  $controller = new PerguntaController($gateway);

  $id = $parts[2] ?? null;

  $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
} elseif ($parts[1] == "perguntasEditadaPor") {
  $gateway = new PerguntaEditadaPorGateway($database);
  $controller = new PerguntaEditadaPorController($gateway);

  $id = $parts[2] ?? null;

  $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
} else {
  http_response_code(404);
  exit;
}
