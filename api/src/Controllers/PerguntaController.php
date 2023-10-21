<?php

class PerguntaController
{
  public function __construct(private PerguntaGateway $gateway)
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
        $data = (array) json_decode(file_get_contents("php://input"), true);
        $data["usuarioId"] = 2;

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
        $this->gateway->delete($id);

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
        $data["usuarioId"] = 1;

        $errors = $this->createValidationErrors($data);

        if (!empty($errors)) {
          http_response_code(422);
          echo json_encode([
            "status" => "error",
            "errors" => $errors
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
