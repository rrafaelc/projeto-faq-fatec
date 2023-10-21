<?php

class AuthController
{
  public function __construct(private UsuarioGateway $gateway)
  {
  }

  public function processRequest(string $method, ?string $id): void
  {
    if ($id) {
      $this->processResourceRequest($method, $id);
    } else {
      $this->processCollectionRequest($method);
    }
  }

  private function processResourceRequest(string $method, string $id): void
  {

    $usuario = $this->gateway->get($id);


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
          echo json_encode([
            "status" => "error",
            "errors" => ["Usuário já existe com esse ra"]
          ]);
          return;
        }

        $usuarioExisteEmail = isset($data["email"]) && $this->gateway->getByEmail($data["email"]) ?? false;

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
      case "POST":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $errors = $this->loginValidationErrors($data);

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => $errors
          ]);
          break;
        }

        $usuario = $this->gateway->getByEmail($data["email"]);

        if (!$usuario) {
          http_response_code(401);
          echo json_encode([
            "status" => "error",
            "errors" => ["Email ou senha incorretos"]
          ]);
          return;
        }

        if (!password_verify($data["senha"], $usuario["senha"])) {
          http_response_code(401);
          echo json_encode([
            "status" => "error",
            "errors" => ["Email ou senha incorretos"]
          ]);
          return;
        }


        http_response_code(200);
        echo json_encode(["message" => "Logado"]);
        break;

      default:
        http_response_code(405);
        header("Allow: POST");
    }
  }

  private function loginValidationErrors(array $data): array
  {
    $errors = [];

    if (!empty($data["email"])) {
      if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "O endereço de e-mail é inválido.";
      }
    } else {
      $errors[] = "email é obrigatório";
    }

    if (empty($data["senha"])) {
      $errors[] = "senha é obrigatório";
    }

    return $errors;
  }
}
