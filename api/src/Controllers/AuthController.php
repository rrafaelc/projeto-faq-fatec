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

          $usuario = $this->gateway->getByRefreshToken($data["refresh_token"]);

          if (!$usuario) {
            http_response_code(401);
            echo json_encode([
              "status" => "error",
              "errors" => ["Refresh Token inválido ou expirado"]
            ]);
            return;
          }

          if (time() > strtotime($usuario["refresh_token_expiration"])) {
            http_response_code(401);
            echo json_encode([
              "status" => "error",
              "errors" => ["Refresh Token inválido ou expirado"]
            ]);
            return;
          }

          $access_token = $this->generateToken($config, $usuario["id"]);

          $this->gateway->updateToken($access_token, $usuario["refresh_token"], $usuario["refresh_token_expiration"], $usuario["id"]);

          $usuario["access_token"] = $access_token;
          $usuario["refresh_token"] = $data["refresh_token"];
          unset($usuario["senha"]);

          echo json_encode($usuario);
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

        $refresh_token = bin2hex(random_bytes(32));

        $expiration_date = date('Y-m-d H:i:s', $config["refresh_token_expiration"]);

        $this->gateway->updateToken($access_token, $refresh_token, $expiration_date, $usuario["id"]);

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

        $this->gateway->updateToken(null, null, null, $usuario["id"]);

        break;
      default:
        http_response_code(405);
        header("Allow: POST");
    }
  }

  public function verifyAccessToken(array $config, ?string $access_token): array | false
  {
    if (empty($access_token)) {
      http_response_code(422);
      echo json_encode([
        "status" => "error",
        "errors" => ["Token obrigatório"]
      ]);

      return false;
    }

    try {
      $token = \Firebase\JWT\JWT::decode($access_token, new Key($config["secret_key"], 'HS256'));

      $usuario = $this->gateway->get($token->sub);

      if ($usuario["access_token"] !== $access_token) {
        http_response_code(401);
        echo json_encode([
          "status" => "error",
          "errors" => ["Token inválido"]
        ]);

        return false;
      }

      return $usuario;
    } catch (Exception $e) {
      http_response_code(401);
      echo json_encode([
        "status" => "error",
        "errors" => ["Token inválido"]
      ]);

      return false;
    }
  }

  private function generateToken(array $config, string $id): string
  {
    $payload = array(
      "iat" => $config["iat"],
      "exp" => $config["access_token_expiration"],
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
