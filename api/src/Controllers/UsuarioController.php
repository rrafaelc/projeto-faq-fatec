<?php

class UsuarioController
{
  public function __construct(private UsuarioGateway $gateway, private array $config, private AuthController $authController, private ?string $token)
  {
  }

  public function processRequest(string $method, ?array $params): void
  {
    if ($params) {
      $this->processResourceRequest($method, $params);
    } else {
      $this->processCollectionRequest($method);
    }
  }

  private function processResourceRequest(string $method, array $params): void
  {
    $temUsuarios = $this->gateway->getCount();

    if (!$temUsuarios) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Sistema não tem úsuarios"],
        "message" => "Crie Diretor(a) em /api/criar-primeira-conta",
      ]);

      return;
    }

    $usuarioLogado = $this->authController->verifyAccessToken($this->config, $this->token);

    if (!$usuarioLogado) return;

    if (isset($params["id"])) {
      $usuario = $this->gateway->get($params["id"]);
    } elseif (isset($params["ra"])) {
      $usuario = $this->gateway->getByRa($params["ra"]);
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
        "error" => ["Usuário não encontrado"]
      ]);

      return;
    }

    switch ($method) {
      case "GET":
        unset($usuario["senha"]);
        echo json_encode($usuario);
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

        $usuarioExisteRa = isset($data["ra"]) && $this->gateway->getByRa($data["ra"]) ?? false;

        if ($usuarioExisteRa) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => ["Usuário já existe com esse ra"]
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

        echo json_encode($usuarioAtualizado);
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

        $cargosPermitidos = [CargoEnum::ADMINISTRADOR, CargoEnum::DIRETOR];

        if (!in_array($usuarioLogado["cargo"], $cargosPermitidos)) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["Acesso negado"],
          ]);

          return;
        }

        if ($usuarioLogado["id"] == $usuario["id"]) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "error" => ["Não permitido excluir sua própria conta"]
          ]);

          return;
        }

        $this->gateway->delete($usuario["id"]);

        http_response_code(204);
        break;

      default:
        http_response_code(405);
        header("Allow: GET, PATCH, DELETE");
    }
  }

  private function processCollectionRequest(string $method): void
  {
    $temUsuarios = $this->gateway->getCount();

    if (!$temUsuarios) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Sistema não tem úsuarios"],
        "message" => "Crie Diretor(a) em /api/criar-primeira-conta",
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
        $cargosPermitidos = [CargoEnum::ADMINISTRADOR, CargoEnum::DIRETOR];

        if (!in_array($usuario["cargo"], $cargosPermitidos)) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["Acesso negado"],
          ]);

          return;
        }

        $data = (array) json_decode(file_get_contents("php://input"), true);

        $criarCargosPermitidos = [CargoEnum::COLABORADOR, CargoEnum::MODERADOR, CargoEnum::ADMINISTRADOR];

        if (!in_array($data["cargo"], $criarCargosPermitidos)) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["cargo deve ser " . CargoEnum::COLABORADOR . ", " . CargoEnum::MODERADOR . " ou " . CargoEnum::ADMINISTRADOR],
          ]);

          return;
        }

        $errors = $this->createValidationErrors($data);

        $usuarioExisteRa = $this->gateway->getByRa($data["ra"]);

        if ($usuarioExisteRa) {
          echo json_encode([
            "status" => "error",
            "errors" => ["Usuário já existe com esse ra"]
          ]);
          return;
        }

        $usuarioExisteEmail = $this->gateway->getByEmail($data["email"]);

        if ($usuarioExisteEmail) {
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

      default:
        http_response_code(405);
        header("Allow: GET, POST");
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

    $cargosPermitidos = [CargoEnum::ADMINISTRADOR, CargoEnum::DIRETOR];

    if (!in_array($usuarioLogado["cargo"], $cargosPermitidos)) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "errors" => ["Acesso negado"],
      ]);

      return;
    }

    $usuario = $this->gateway->get($id);

    if (!$usuario) {
      http_response_code(404);
      echo json_encode([
        "status" => "error",
        "error" => ["Usuário não encontrado"]
      ]);

      return;
    }

    if ($usuarioLogado["id"] == $id) {
      http_response_code(403);
      echo json_encode([
        "status" => "error",
        "error" => ["Não permitido alterar a suspensão da sua própria conta"]
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

  public function temUsuarios(): void
  {
    $temUsuarios = $this->gateway->getCount();

    echo json_encode((bool) $temUsuarios);
  }

  public function criarPrimeiraConta(string $method): void
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

        $data["cargo"] = CargoEnum::DIRETOR;

        $errors = $this->createValidationErrors($data);

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => $errors
          ]);
          break;
        }

        $diretorCriado = $this->gateway->create($data);
        unset($diretorCriado["senha"]);

        http_response_code(201);
        echo json_encode($diretorCriado);
        break;

      default:
        http_response_code(405);
        header("Allow:  POST");
    }
  }

  private function createValidationErrors(array $data): array
  {
    $errors = [];

    if (!empty($data["nome_completo"])) {
      if (strlen($data["nome_completo"]) < 3) {
        $errors[] = "nome_completo mínimo 3 caracteres";
      }
    } else {
      $errors[] = "nome_completo é obrigatório";
    }

    if (!empty($data["ra"])) {
      if (strlen($data["ra"]) < 3) {
        $errors[] = "ra mínimo 3 caracteres";
      }
    } else {
      $errors[] = "ra é obrigatório";
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

      if ($cargo !== CargoEnum::COLABORADOR  && $cargo !== CargoEnum::MODERADOR  && $cargo !== CargoEnum::ADMINISTRADOR && $cargo !== CargoEnum::DIRETOR) {
        $errors[] = "cargo deve ser " . CargoEnum::COLABORADOR . ", " . CargoEnum::MODERADOR . ", " . CargoEnum::ADMINISTRADOR . " ou " . CargoEnum::DIRETOR;
      }
    }

    return $errors;
  }

  private function patchValidationErrors(array $data): array
  {
    $errors = [];

    if (isset($data["nome_completo"])) {
      if (strlen($data["nome_completo"]) < 3) {
        $errors[] = "nome_completo mínimo 3 caracteres";
      }
    }

    if (isset($data["ra"])) {
      if (strlen($data["ra"]) < 3) {
        $errors[] = "ra mínimo 3 caracteres";
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

      if ($cargo !== CargoEnum::COLABORADOR  && $cargo !== CargoEnum::MODERADOR  && $cargo !== CargoEnum::ADMINISTRADOR && $cargo !== CargoEnum::DIRETOR) {
        $errors[] = "cargo deve ser " . CargoEnum::COLABORADOR . ", " . CargoEnum::MODERADOR . ", " . CargoEnum::ADMINISTRADOR . " ou " . CargoEnum::DIRETOR;
      }
    }

    return $errors;
  }
}
