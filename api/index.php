<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
  require __DIR__ . "/src/$class.php";
});

set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$getPath = explode("/projeto-faq-fatec/api", $_SERVER["REQUEST_URI"]);
$parts = explode("/", $getPath[1]);

if ($parts[1] != "perguntas") {
  http_response_code(404);
  exit;
}

$id = $parts[2] ?? null;

$database = new Database("localhost", "projeto-faq", "root", "");

$database->getConnection();

$controller = new PerguntaController;

$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
