<?php

class PerguntaSugeridaController
{
  public function __construct(private PerguntaSugeridaGateway $gateway, private array $config, private AuthController $authController, private ?string $token)
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
    $perguntaSugerida = $this->gateway->get($id);

    if (!$perguntaSugerida) {
      http_response_code(404);
      echo json_encode([
        "status" => "error",
        "message" => "Pergunta sugerida não encontrada"
      ]);
      return;
    }

    switch ($method) {
      case "GET":
        $usuarioLogado = $this->authController->verifyAccessToken($this->config, $this->token);

        if (!$usuarioLogado) return;

        echo json_encode($perguntaSugerida);
        break;
      case "PUT":
        $usuarioLogado = $this->authController->verifyAccessToken($this->config, $this->token);

        if (!$usuarioLogado) return;

        if ((bool) $usuarioLogado["esta_suspenso"]) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["Usuário suspenso, acesso negado"]
          ]);
          return;
        }

        $perguntaSugeridaAtualizada = $this->gateway->update($id, $usuarioLogado["id"]);

        http_response_code(200);
        echo json_encode($perguntaSugeridaAtualizada);
        break;

      case "DELETE":
        $usuarioLogado = $this->authController->verifyAccessToken($this->config, $this->token);

        if (!$usuarioLogado) return;

        if ((bool) $usuarioLogado["esta_suspenso"]) {
          http_response_code(403);
          echo json_encode([
            "status" => "error",
            "errors" => ["Usuário suspenso, acesso negado"]
          ]);
          return;
        }

        $this->gateway->delete($id);

        http_response_code(204);
        break;

      default:
        http_response_code(405);
        header("Allow: GET, PUT, DELETE");
    }
  }

  private function processCollectionRequest(string $method): void
  {
    switch ($method) {
      case "GET":
        $usuarioLogado = $this->authController->verifyAccessToken($this->config, $this->token);

        if (!$usuarioLogado) return;

        $pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT) ?? 1;

        $qtdPorPg = filter_input(INPUT_GET, "quantidade_por_pagina", FILTER_SANITIZE_NUMBER_INT) ?? 10;

        echo json_encode($this->gateway->getAll($pagina, $qtdPorPg, isset($_GET["order"]) ? $_GET["order"] : ''));
        break;
      case "POST":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $errors = $this->createValidationErrors($data);

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => $errors
          ]);
          break;
        }

        $perguntaSugeridaCriada = $this->gateway->create($data);

        http_response_code(201);
        echo json_encode($perguntaSugeridaCriada);
        break;

      default:
        http_response_code(405);
        header("Allow: GET, POST");
    }
  }

  private function createValidationErrors(array $data): array
  {
    $errors = [];

    if (empty($data["nome"])) {
      $errors[] = "nome é obrigatório";
    } else if (strlen($data["nome"]) < 3 || strlen($data["nome"]) > 100) {
      $errors[] = "nome mínimo 3 e máximo 100 caracteres";
    }

    if (empty($data["email"])) {
      $errors[] = "e-mail é obrigatório";
    } else if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
      $errors[] = "e-mail inválido";
    }

    $numeroLimpo = preg_replace("/[^0-9]/", "", $data["telefone"]);

    if (empty($numeroLimpo)) {
      $errors[] = "telefone é obrigatório";
    } else if (strlen($numeroLimpo) < 10 || strlen($numeroLimpo) > 11) {
      $errors[] = "telefone deve ter 10 ou 11 dígitos";
    }

    if (empty($data["pergunta"])) {
      $errors[] = "pergunta é obrigatório";
    } else if (strlen($data["pergunta"]) < 10 || strlen($data["pergunta"]) > 650) {
      $errors[] = "pergunta mínimo 10 e máximo 650 caracteres";
    }

    return $errors;
  }
}
