<?php

class UsuarioController
{
  private $gateway;
  private $config;
  private $authController;
  private $token;

  public function __construct(UsuarioGateway $gateway, array $config, AuthController $authController, ?string $token)
  {
    $this->gateway = $gateway;
    $this->config = $config;
    $this->authController = $authController;
    $this->token = $token;
  }


  public function processRequest(string $method, ?array $params)
  {
    if ($params) {
      $this->processResourceRequest($method, $params);
    } else {
      $this->processCollectionRequest($method);
    }
  }

  private function processResourceRequest(string $method, array $params)
  {
    $temUsuarios = $this->gateway->getCount();

    if (!$temUsuarios) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Sistema não tem úsuarios"],
        "message" => "Crie Administrador(a) em /api/criar-primeira-conta",
      ]);

      return;
    }

    $usuarioLogado = $this->authController->verifyAccessToken($this->config, $this->token);

    if (!$usuarioLogado) return;

    if (isset($params["id"])) {
      $usuario = $this->gateway->get($params["id"]);
    } elseif (isset($params["email"])) {
      $usuario = $this->gateway->getByEmail($params["email"]);
    } else {
      http_response_code(422);
      echo json_encode([
        "status" => "error",
        "errors" => ["Nenhum paramêtro enviado"]
      ]);
      return;
    }

    if (!$usuario) {
      http_response_code(404);
      echo json_encode([
        "status" => "error",
        "errors" => ["Usuário não encontrado"]
      ]);

      return;
    }

    switch ($method) {
      case "GET":
        unset($usuario["senha"]);
        echo json_encode($usuario);
        break;
      case "DELETE":
        $usuarioLogado = $this->authController->verifyAccessToken($this->config, $this->token);

        if (!$usuarioLogado) return;

        if (isset($params["id"])) {
          $usuario = $this->gateway->get($params["id"]);
        } else {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => ["Nenhum paramêtro enviado"]
          ]);
          return;
        }

        $cargosPermitidos = [CargoEnum::ADMINISTRADOR];

        if (!in_array($usuarioLogado["cargo"], $cargosPermitidos)) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["Acesso negado"],
          ]);

          return;
        }

        if ((bool) $usuarioLogado["esta_suspenso"]) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["Usuário suspenso, acesso negado"]
          ]);
          return;
        }

        if ($usuarioLogado["id"] == $usuario["id"]) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["Não permitido excluir sua própria conta"]
          ]);

          return;
        }

        $this->gateway->delete($usuario["id"]);

        http_response_code(204);
        break;

      default:
        http_response_code(405);
        header("Allow: GET, DELETE");
    }
  }

  private function processCollectionRequest(string $method)
  {
    $temUsuarios = $this->gateway->getCount();

    if (!$temUsuarios) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Sistema não tem úsuarios"],
        "message" => "Crie Administrador(a) em /api/criar-primeira-conta",
      ]);

      return;
    }

    $usuario = $this->authController->verifyAccessToken($this->config, $this->token);

    if (!$usuario) return;

    switch ($method) {
      case "GET":
        echo json_encode($this->gateway->getAll());
        break;
      case "POST":
        $cargosPermitidos = [CargoEnum::ADMINISTRADOR];

        if (!in_array($usuario["cargo"], $cargosPermitidos)) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["Acesso negado"],
          ]);

          return;
        }

        if ((bool) $usuario["esta_suspenso"]) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["Usuário suspenso, acesso negado"]
          ]);
          return;
        }

        $data = (array) json_decode(file_get_contents("php://input"), true);

        $criarCargosPermitidos = [CargoEnum::ADMINISTRADOR, CargoEnum::MODERADOR];

        if (!in_array($data["cargo"], $criarCargosPermitidos)) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["cargo deve ser " . CargoEnum::ADMINISTRADOR . " ou " . CargoEnum::MODERADOR],
          ]);

          return;
        }

        $errors = $this->createValidationErrors($data);

        $usuarioExisteEmail = $this->gateway->getByEmail($data["email"]);

        if ($usuarioExisteEmail) {
          http_response_code(400);
          echo json_encode([
            "status" => "error",
            "errors" => ["Usuário já existe com esse email"]
          ]);
          return;
        }

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => $errors
          ]);
          break;
        }

        $usuarioCriado = $this->gateway->create($data);
        unset($usuarioCriado["senha"]);

        http_response_code(201);
        echo json_encode($usuarioCriado);
        break;

      case "PATCH":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $errors = $this->patchValidationErrors($data);

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => $errors
          ]);
          break;
        }

        if (!password_verify($data["senha_atual"], $usuario["senha"])) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["Senha incorreta"]
          ]);
          return;
        }

        $usuarioExisteEmail = isset($data["email"]) && $this->gateway->getByEmail($data["email"]) ?? false;

        if ($usuarioExisteEmail) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => ["Usuário já existe com esse email"]
          ]);
          return;
        }

        $usuarioAtualizado = $this->gateway->update($usuario, $data);

        if (isset($data["senha"]) && $data["senha"]) {
          $this->gateway->updateToken(null, null, null, $usuario["id"]);

          unset($usuarioAtualizado["senha"]);
          $usuarioAtualizado["access_token"] = null;
          $usuarioAtualizado["refresh_token"] = null;
          $usuarioAtualizado["refresh_token_expiration"] = null;

          echo json_encode($usuarioAtualizado);
          return;
        }

        echo json_encode($usuarioAtualizado);
        break;
      default:
        http_response_code(405);
        header("Allow: GET, POST, PATCH");
    }
  }

  public function alterarCargo(string $method, ?string $id)
  {
    $usuarioLogado = $this->authController->verifyAccessToken($this->config, $this->token);

    if (!$usuarioLogado) return;

    if (!$id) {
      http_response_code(422);
      echo json_encode([
        "status" => "error",
        "errors" => ["Nenhum paramêtro enviado"]
      ]);
      return;
    }

    $cargosPermitidos = [CargoEnum::ADMINISTRADOR];

    if (!in_array($usuarioLogado["cargo"], $cargosPermitidos)) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Acesso negado"],
      ]);

      return;
    }

    if ((bool) $usuarioLogado["esta_suspenso"]) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Usuário suspenso, acesso negado"]
      ]);
      return;
    }

    $usuario = $this->gateway->get($id);

    if (!$usuario) {
      http_response_code(404);
      echo json_encode([
        "status" => "error",
        "errors" => ["Usuário não encontrado"]
      ]);

      return;
    }

    if ($usuarioLogado["id"] == $id) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Não permitido alterar o cargo da sua própria conta"]
      ]);

      return;
    }

    switch ($method) {
      case "POST":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        if (!array_key_exists("cargo", $data)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => ["cargo é obrigatório"]
          ]);
          return;
        }

        if ($data["cargo"] !== CargoEnum::ADMINISTRADOR && $data["cargo"] !== CargoEnum::MODERADOR) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => ["cargo deve ser " . CargoEnum::ADMINISTRADOR . " ou " . CargoEnum::MODERADOR]
          ]);
          return;
        }

        $this->gateway->updateCargo($data["cargo"], $id);

        break;
      default:
        http_response_code(405);
        header("Allow:  POST");
    }
  }

  public function suspender(string $method, ?string $id)
  {
    $usuarioLogado = $this->authController->verifyAccessToken($this->config, $this->token);

    if (!$usuarioLogado) return;

    if (!$id) {
      http_response_code(422);
      echo json_encode([
        "status" => "error",
        "errors" => ["Nenhum paramêtro enviado"]
      ]);
      return;
    }

    $cargosPermitidos = [CargoEnum::ADMINISTRADOR];

    if (!in_array($usuarioLogado["cargo"], $cargosPermitidos)) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Acesso negado"],
      ]);

      return;
    }

    if ((bool) $usuarioLogado["esta_suspenso"]) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Usuário suspenso, acesso negado"]
      ]);
      return;
    }

    $usuario = $this->gateway->get($id);

    if (!$usuario) {
      http_response_code(404);
      echo json_encode([
        "status" => "error",
        "errors" => ["Usuário não encontrado"]
      ]);

      return;
    }

    if ($usuarioLogado["id"] == $id) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Não permitido alterar a suspensão da sua própria conta"]
      ]);

      return;
    }

    switch ($method) {
      case "POST":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        if (!array_key_exists("esta_suspenso", $data)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => ["esta_suspenso é obrigatório"]
          ]);
          return;
        } elseif (!is_bool($data["esta_suspenso"])) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => ["esta_suspenso deve ser um valor booleano (true ou false)"]
          ]);
          return;
        }

        $this->gateway->updateSuspensao($data["esta_suspenso"], $id);

        break;
      default:
        http_response_code(405);
        header("Allow:  POST");
    }
  }

  public function resetarSenha(string $method, ?string $id)
  {
    $usuarioLogado = $this->authController->verifyAccessToken($this->config, $this->token);

    if (!$usuarioLogado) return;

    if (!$id) {
      http_response_code(422);
      echo json_encode([
        "status" => "error",
        "errors" => ["Nenhum paramêtro enviado"]
      ]);
      return;
    }

    $cargosPermitidos = [CargoEnum::ADMINISTRADOR];

    if (!in_array($usuarioLogado["cargo"], $cargosPermitidos)) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Acesso negado"],
      ]);

      return;
    }

    if ((bool) $usuarioLogado["esta_suspenso"]) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Usuário suspenso, acesso negado"]
      ]);
      return;
    }

    $usuario = $this->gateway->get($id);

    if (!$usuario) {
      http_response_code(404);
      echo json_encode([
        "status" => "error",
        "errors" => ["Usuário não encontrado"]
      ]);

      return;
    }

    switch ($method) {
      case "PATCH":
        $senhaResetada =  bin2hex(random_bytes(4));

        $this->gateway->update($usuario, ["senha" => $senhaResetada]);

        $this->gateway->updateToken(null, null, null, $usuario["id"]);

        echo json_encode([
          "nova_senha" => $senhaResetada
        ]);
        break;
      default:
        http_response_code(405);
        header("Allow: PATCH");
    }
  }

  public function temUsuarios()
  {
    $temUsuarios = $this->gateway->getCount();

    echo json_encode((bool) $temUsuarios);
  }

  public function criarPrimeiraConta(string $method)
  {
    $temUsuarios = $this->gateway->getCount();

    if ($temUsuarios) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Acesso negado"],
        "message" => "Sistema tem usuários"
      ]);

      return;
    }

    switch ($method) {
      case "POST":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $data["cargo"] = CargoEnum::ADMINISTRADOR;

        $errors = $this->createValidationErrors($data);

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => $errors
          ]);
          break;
        }

        $administradorCriado = $this->gateway->create($data);
        unset($administradorCriado["senha"]);

        http_response_code(201);
        echo json_encode($administradorCriado);
        break;

      default:
        http_response_code(405);
        header("Allow:  POST");
    }
  }

  private function createValidationErrors(array $data)
  {
    $errors = [];

    if (!empty($data["nome_completo"])) {
      if (strlen($data["nome_completo"]) < 3) {
        $errors[] = "nome_completo mínimo 3 caracteres";
      }
    } else {
      $errors[] = "nome_completo é obrigatório";
    }

    if (!empty($data["email"])) {
      if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "O endereço de e-mail é inválido.";
      }
    } else {
      $errors[] = "email é obrigatório";
    }

    if (!empty($data["senha"])) {
      if (strlen($data["senha"]) < 8) {
        $errors[] = "senha mínimo 8 caracteres";
      }
    } else {
      $errors[] = "senha é obrigatório";
    }

    if (isset($data["cargo"])) {
      $cargo = $data["cargo"];

      if ($cargo !== CargoEnum::ADMINISTRADOR  && $cargo !== CargoEnum::MODERADOR) {
        $errors[] = "cargo deve ser " . CargoEnum::ADMINISTRADOR . " ou " . CargoEnum::MODERADOR;
      }
    }

    return $errors;
  }

  private function patchValidationErrors(array $data)
  {
    $errors = [];

    if (empty($data["senha_atual"])) {
      $errors[] = "senha_atual é obrigatório";
    }

    if (isset($data["nome_completo"])) {
      if (strlen($data["nome_completo"]) < 3) {
        $errors[] = "nome_completo mínimo 3 caracteres";
      }
    }

    if (isset($data["email"])) {
      if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "O endereço de e-mail é inválido.";
      }
    }

    if (isset($data["senha"])) {
      if (strlen($data["senha"]) < 8) {
        $errors[] = "senha mínimo 8 caracteres";
      }
    }

    if (isset($data["cargo"])) {
      $cargo = $data["cargo"];

      if ($cargo !== CargoEnum::ADMINISTRADOR  && $cargo !== CargoEnum::MODERADOR) {
        $errors[] = "cargo deve ser " . CargoEnum::ADMINISTRADOR . " ou " . CargoEnum::MODERADOR;
      }
    }

    return $errors;
  }
}
