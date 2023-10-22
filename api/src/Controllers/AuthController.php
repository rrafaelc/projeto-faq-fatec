<?php

use Firebase\JWT\Key;

class AuthController
{
  public function __construct(private UsuarioGateway $gateway, private array $config)
  {
  }

  public function processRequest(string $method, bool $isRefreshToken = false): void
  {

    $this->processCollectionRequest($method, $this->config, $isRefreshToken);
  }

  private function processCollectionRequest(string $method, array $config, bool $isRefreshToken): void
  {
    switch ($method) {
      case "POST":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        if ($isRefreshToken) {
          $errors = $this->refreshTokenValidationErrors($data);

          if (!empty($errors)) {
            http_response_code(422);
            echo json_encode([
              "status" => "error",
              "errors" => $errors
            ]);
            break;
          }

          $usuarioValido = $this->gateway->getByRefreshToken($data["refresh_token"]);

          if (!$usuarioValido) {
            http_response_code(401);
            echo json_encode([
              "status" => "error",
              "errors" => ["Token inválido"]
            ]);
            return;
          }

          try {
            $token = \Firebase\JWT\JWT::decode($data["refresh_token"], new Key($config["secret_key"], 'HS256'));

            $usuario = $this->gateway->get($token->sub);
            $access_token = $this->generateToken($config, $token->sub);

            $usuario["access_token"] = $access_token;
            unset($usuario["senha"]);

            echo json_encode($usuario);
          } catch (Exception $e) {
            http_response_code(401);
            echo json_encode([
              "status" => "error",
              "message" => "Token inválido",
              "exception" => $e->getMessage(),
            ]);
          }

          return;
        }

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

        $access_token = $this->generateToken($config, $usuario["id"]);

        $refresh_token_payload = array(
          "sub" => $usuario["id"],
          "exp" => $config["refresh_token_expiration"],
        );

        $refresh_token = \Firebase\JWT\JWT::encode($refresh_token_payload, $config["secret_key"], 'HS256');

        $this->gateway->saveRefreshToken($refresh_token, $usuario["id"]);

        $usuario["access_token"] = $access_token;
        $usuario["refresh_token"] = $refresh_token;
        unset($usuario["senha"]);

        echo json_encode($usuario);
        break;

      default:
        http_response_code(405);
        header("Allow: POST");
    }
  }

  public function logout(string $method, array $config, ?string $access_token): void
  {
    switch ($method) {
      case "POST":
        if (empty($access_token)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => ["Token obrigatório"]
          ]);
          return;
        }

        $usuario = $this->verifyAccessToken($config, $access_token);

        if (!$usuario) return;

        $this->gateway->update($usuario, ["refresh_token" => null]);

        break;
      default:
        http_response_code(405);
        header("Allow: POST");
    }
  }

  public function verifyAccessToken(array $config, string $access_token): array | false
  {
    try {
      $token = \Firebase\JWT\JWT::decode($access_token, new Key($config["secret_key"], 'HS256'));

      $usuario = $this->gateway->get($token->sub);

      return $usuario;
    } catch (Exception $e) {
      http_response_code(401);
      echo json_encode([
        "status" => "error",
        "message" => "Token inválido",
        "exception" => $e->getMessage(),
      ]);

      return false;
    }
  }

  private function generateToken(array $config, string $id): string
  {
    $payload = array(
      "iat" => $config["issuedat_claim"],
      "nbf" => $config["notbefore_claim"],
      "exp" => $config["expire_claim"],
      "sub" => $id,
    );

    $token = \Firebase\JWT\JWT::encode($payload, $config["secret_key"], 'HS256');

    return $token;
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

  private function refreshTokenValidationErrors(array $data): array
  {
    $errors = [];

    if (empty($data["refresh_token"])) {
      $errors[] = "refresh_token é obrigatório";
    }

    return $errors;
  }
}
