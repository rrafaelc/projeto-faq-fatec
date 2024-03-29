<?php

class PerguntaController
{
  public function __construct(private PerguntaGateway $gateway, private array $config, private AuthController $authController, private ?string $token)
  {
  }

  public function processRequest(string $method, ?string $id, array $ordenacao): void
  {
    if ($id) {
      $this->processResourceRequest($method, $id);
    } else {
      $this->processCollectionRequest($method, $ordenacao);
    }
  }

  private function processResourceRequest(string $method, string $id): void
  {
    $pergunta = $this->gateway->get($id);

    if (!$pergunta) {
      http_response_code(404);
      echo json_encode([
        "status" => "error",
        "message" => "Pergunta não encontrada"
      ]);
      return;
    }

    switch ($method) {
      case "GET":
        echo json_encode($pergunta);
        break;
      case "PATCH":
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

        $data = (array) json_decode(file_get_contents("php://input"), true);
        $data["usuarioId"] = $usuarioLogado["id"];

        $errors = $this->patchValidationErrors($data);

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => $errors
          ]);
          break;
        }
        $perguntaAtualizada = $this->gateway->update($pergunta, $data);

        echo json_encode($perguntaAtualizada);
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
        header("Allow: GET, PATCH, DELETE");
    }
  }

  private function processCollectionRequest(string $method, array $ordenacao): void
  {
    switch ($method) {
      case "GET":
        $pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT) ?? 1;

        $qtdPorPg = filter_input(INPUT_GET, "quantidade_por_pagina", FILTER_SANITIZE_NUMBER_INT) ?? 10;

        $titulo = $_GET['titulo'] ?? '';

        echo json_encode($this->gateway->getAll($ordenacao, $pagina, $qtdPorPg, isset($_GET["order"]) ? $_GET["order"] : '', $titulo));
        break;
      case "POST":
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

        $data = (array) json_decode(file_get_contents("php://input"), true);
        $data["usuarioId"] = $usuarioLogado["id"];

        $errors = $this->createValidationErrors($data);

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => $errors
          ]);
          break;
        }

        $perguntaExiste = $this->gateway->perguntaExists($data["pergunta"]);

        if ($perguntaExiste) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => ["Essa pergunta já existe no banco"]
          ]);
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

  public function porUsuarioLogado(string $method): void
  {
    switch ($method) {
      case "GET":
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

        $pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT) ?? 1;

        $qtdPorPg = filter_input(INPUT_GET, "quantidade_por_pagina", FILTER_SANITIZE_NUMBER_INT) ?? 10;

        echo json_encode($this->gateway->getAllPorUsuario($usuarioLogado["id"], $pagina, $qtdPorPg, isset($_GET["order"]) ? $_GET["order"] : ''));
        break;

      default:
        http_response_code(405);
        header("Allow: GET");
    }
  }

  public function incrementarCurtidas(string $method, string $id): void
  {
    switch ($method) {
      case "PATCH":
        $pergunta = $this->gateway->get($id);

        if (!$pergunta) {
          http_response_code(404);
          echo json_encode([
            "status" => "error",
            "message" => "Pergunta não encontrada"
          ]);
          return;
        }

        $perguntaCurtidasIncrementada = $this->gateway->updateCurtidas($pergunta, ["curtidas" => $pergunta["curtidas"] + 1]);

        http_response_code(201);
        echo json_encode($perguntaCurtidasIncrementada);
        break;

      default:
        http_response_code(405);
        header("Allow: PATCH");
    }
  }

  public function decrementarCurtidas(string $method, string $id): void
  {
    switch ($method) {
      case "PATCH":
        $pergunta = $this->gateway->get($id);

        if (!$pergunta) {
          http_response_code(404);
          echo json_encode([
            "status" => "error",
            "message" => "Pergunta não encontrada"
          ]);
          return;
        }

        $decrementar = $pergunta["curtidas"] - 1;

        if ($decrementar < 0) {
          $decrementar = 0;
        }

        $perguntaCurtidasIncrementada = $this->gateway->updateCurtidas($pergunta, ["curtidas" => $decrementar]);

        http_response_code(201);
        echo json_encode($perguntaCurtidasIncrementada);
        break;

      default:
        http_response_code(405);
        header("Allow: PATCH");
    }
  }

  public function getTotais(string $method): void
  {
    switch ($method) {
      case "GET":
        $totalPerguntas = $this->gateway->getTotalPerguntas();
        $totalPrioridadeAlta = $this->gateway->getTotalPrioridadeAlta();
        $totalCurtidas = $this->gateway->getTotalCurtidas();

        echo json_encode([
          "total_perguntas" => $totalPerguntas,
          "total_prioridade_alta" => $totalPrioridadeAlta,
          "total_curtidas" => $totalCurtidas
        ]);

        break;

      default:
        http_response_code(405);
        header("Allow: GET");
    }
  }

  private function createValidationErrors(array $data): array
  {
    $errors = [];

    if (array_key_exists("usuarioId", $data)) {
      if (filter_Var($data["usuarioId"], FILTER_VALIDATE_INT) === false) {
        $errors[] = "usuarioId deve ser do tipo inteiro";
      }
    } else {
      $errors[] = "usuarioId é obrigatório";
    }

    if (empty($data["pergunta"])) {
      $errors[] = "pergunta é obrigatório";
    }

    if (empty($data["resposta"])) {
      $errors[] = "resposta é obrigatório";
    }

    if (isset($data["prioridade"])) {
      $prioridade = $data["prioridade"];

      if ($prioridade !== "Alta" && $prioridade !== "Normal") {
        $errors[] = "prioridade deve ser 'Alta' ou 'Normal'";
      }
    }

    return $errors;
  }

  private function patchValidationErrors(array $data): array
  {
    $errors = [];

    if (array_key_exists("usuarioId", $data)) {
      if (filter_Var($data["usuarioId"], FILTER_VALIDATE_INT) === false) {
        $errors[] = "usuarioId deve ser do tipo inteiro";
      }
    } else {
      $errors[] = "usuarioId é obrigatório";
    }

    if (isset($data["pergunta"])) {
      if (empty($data["pergunta"])) {
        $errors[] = "pergunta não pode estar vazio";
      }
    }

    if (isset($data["resposta"])) {
      if (empty($data["resposta"])) {
        $errors[] = "resposta não pode estar vazio";
      }
    }

    if (array_key_exists("curtidas", $data)) {
      if (filter_Var($data["curtidas"], FILTER_VALIDATE_INT) === false) {
        $errors[] = "curtidas deve ser do tipo inteiro";
      }

      if ($data["curtidas"] < 0) {
        $errors[] = "curtidas deve ser maior ou igual à 0";
      }
    }

    if (isset($data["prioridade"])) {
      $prioridade = $data["prioridade"];

      if ($prioridade !== "Alta" && $prioridade !== "Normal") {
        $errors[] = "prioridade deve ser 'Alta' ou 'Normal'";
      }
    }

    return $errors;
  }
}
