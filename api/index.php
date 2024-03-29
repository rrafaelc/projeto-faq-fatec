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

date_default_timezone_set('America/Sao_Paulo');

$config = [
  "secret_key" => $_ENV["JWT_KEY"],
  "iat" => $iat,
  "access_token_expiration" => $access_token_expiration,
  "refresh_token_expiration" => $refresh_token_expiration,
];

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"], $_ENV["DB_PORT"]);

$getPath = explode("/projeto-faq-fatec/api", $_SERVER["REQUEST_URI"]);
$parts = explode("/", $getPath[1]);

// Pra poder usar os valores do $_GET;
if (in_array("?", str_split($parts[count($parts) - 1]))) {
  $aux = explode("?", $parts[count($parts) - 1]);
  $parts[count($parts) - 1] = $aux[0];
}

$token = getBearerToken();

$usuarioGateway = new UsuarioGateway($database);
$authController = new AuthController($usuarioGateway, $config);

if ($parts[1] == "pergunta") {
  $perguntaGateway = new PerguntaGateway($database);
  $controller = new PerguntaController($perguntaGateway, $config, $authController, $token);

  if (isset($parts[2]) && $parts[2] == "usuario") {
    $controller->porUsuarioLogado($_SERVER["REQUEST_METHOD"]);

    return;
  }


  if (isset($parts[2]) && $parts[2] == "incrementar-curtidas") {
    $id =  isset($parts[3]) ? $parts[3] : "";

    $controller->incrementarCurtidas($_SERVER["REQUEST_METHOD"], $id);

    return;
  }

  if (isset($parts[2]) && $parts[2] == "decrementar-curtidas") {
    $id =  isset($parts[3]) ? $parts[3] : "";

    $controller->decrementarCurtidas($_SERVER["REQUEST_METHOD"], $id);

    return;
  }

  if (isset($parts[2]) && $parts[2] == "mais-buscados") {

    $controller->processRequest($_SERVER["REQUEST_METHOD"], null, ["MaisCurtidas" => true]);

    return;
  }

  if (isset($parts[2]) && $parts[2] == "totais") {

    $controller->getTotais($_SERVER["REQUEST_METHOD"]);

    return;
  }

  $id = $parts[2] ?? null;

  $maisAlta = isset($_GET["mais-alta"]) ? ($_GET["mais-alta"] === "false" ? false : (bool)$_GET["mais-alta"]) : true;

  $controller->processRequest($_SERVER["REQUEST_METHOD"], $id, ["MaisAlta" => $maisAlta]);
} else if ($parts[1] == "pergunta-sugerida") {
  $perguntaSugeridaGateway = new PerguntaSugeridaGateway($database);
  $controller = new PerguntaSugeridaController($perguntaSugeridaGateway, $config, $authController, $token);

  $id = $parts[2] ?? null;

  $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
} elseif ($parts[1] == "usuario") {
  $usuarioGateway = new UsuarioGateway($database);
  $controller = new UsuarioController($usuarioGateway, $config, $authController, $token);

  if (isset($parts[2]) && $parts[2] == "resetar-senha") {
    $id =  isset($parts[3]) ? $parts[3] : "";

    $controller->resetarSenha($_SERVER["REQUEST_METHOD"], $id);
    return;
  }

  if (isset($parts[2]) && $parts[2] == "email") {
    $params =  isset($parts[3]) ? ["email" => $parts[3]] : [""];

    $controller->processRequest($_SERVER["REQUEST_METHOD"], $params);
    return;
  }

  if (isset($parts[2]) && $parts[2] == "alterar-cargo") {
    $id =  isset($parts[3]) ? $parts[3] : "";

    $controller->alterarCargo($_SERVER["REQUEST_METHOD"], $id);
    return;
  }

  if (isset($parts[2]) && $parts[2] == "suspender") {
    $id =  isset($parts[3]) ? $parts[3] : "";

    $controller->suspender($_SERVER["REQUEST_METHOD"], $id);
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
} elseif ($parts[1] == "tem-usuarios") {
  $usuarioGateway = new UsuarioGateway($database);
  $controller = new UsuarioController($usuarioGateway, $config, $authController, $token);

  $controller->temUsuarios();
} elseif ($parts[1] == "criar-primeira-conta") {
  $usuarioGateway = new UsuarioGateway($database);
  $controller = new UsuarioController($usuarioGateway, $config, $authController, $token);

  $controller->criarPrimeiraConta($_SERVER["REQUEST_METHOD"]);
} else {
  http_response_code(404);
  exit;
}
