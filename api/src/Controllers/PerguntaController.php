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
      echo json_encode(["message" => "Pergunta não encontrada"]);
      return;
    }

    switch ($method) {
      case "GET":
        echo json_encode($pergunta);
        break;
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

    if (empty($data["usuarioId"])) {
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

    // if (array_key_exists("size", $data))
    // {
    //   if (filter_Var($data["size"], FILTER_VALIDATE_INT) === false){
    //     $errors[] = "size muste be an integer";
    //   }
    // }

    return $errors;
  }
}
