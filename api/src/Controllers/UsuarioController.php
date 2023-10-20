<?php

class UsuarioController
{
  public function __construct(private UsuarioGateway $gateway)
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
    if (isset($params["id"])) {
      $usuario = $this->gateway->get($params["id"]);
    } elseif (isset($params["ra"])) {
      $usuario = $this->gateway->getByRa($params["ra"]);
    } elseif (isset($params["email"])) {
      $usuario = $this->gateway->getByEmail($params["email"]);
    }

    if (!$usuario) {
      http_response_code(404);
      echo json_encode(["message" => "Usuario não encontrado"]);
      return;
    }

    switch ($method) {
      case "GET":
        echo json_encode($usuario);
        break;
      case "PATCH":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $usuarioExisteRa = isset($data["ra"]) && $this->gateway->getByRa($data["ra"]) ?? false;

        if ($usuarioExisteRa) {
          echo json_encode(["errors" => ["Usuário já existe com esse ra"]]);
          return;
        }

        $usuarioExisteEmail = isset($data["email"]) && $this->gateway->getByEmail($data["email"]) ?? false;

        if ($usuarioExisteEmail) {
          echo json_encode(["errors" => ["Usuário já existe com esse email"]]);
          return;
        }

        $errors = $this->patchValidationErrors($data);

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode(["errors" => $errors]);
          break;
        }
        $usuarioAtualizada = $this->gateway->update($usuario, $data);

        echo json_encode($usuarioAtualizada);
        break;
      case "DELETE":
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
    switch ($method) {
      case "GET":
        echo json_encode($this->gateway->getAll());
        break;
      case "POST":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $errors = $this->createValidationErrors($data);

        $usuarioExisteRa = $this->gateway->getByRa($data["ra"]);

        if ($usuarioExisteRa) {
          echo json_encode(["errors" => ["Usuário já existe com esse ra"]]);
          return;
        }

        $usuarioExisteEmail = $this->gateway->getByEmail($data["email"]);

        if ($usuarioExisteEmail) {
          echo json_encode(["errors" => ["Usuário já existe com esse email"]]);
          return;
        }

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode(["errors" => $errors]);
          break;
        }

        $perguntaCriada = $this->gateway->create($data);

        http_response_code(201);
        echo json_encode($perguntaCriada);
        break;

      default:
        http_response_code(405);
        header("Allow: GET, POST");
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

      if ($cargo !== "Colaborador" && $cargo !== "Moderador" && $cargo !== "Administrador" && $cargo !== "Diretor") {
        $errors[] = "cargo deve ser 'Colaborador', 'Moderador', 'Administrador' ou 'Diretor'";
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

      if ($cargo !== "Colaborador" && $cargo !== "Moderador" && $cargo !== "Administrador" && $cargo !== "Diretor") {
        $errors[] = "cargo deve ser 'Colaborador', 'Moderador', 'Administrador' ou 'Diretor'";
      }
    }

    if (array_key_exists("esta_suspenso", $data)) {
      if (!is_bool($data["esta_suspenso"])) {
        $errors[] = "esta_suspenso deve ser um valor booleano (true ou false)";
      }
    }

    return $errors;
  }
}
