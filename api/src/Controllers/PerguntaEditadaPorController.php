<?php

class PerguntaEditadaPorController
{
  public function __construct(private PerguntaEditadaPorGateway $gateway)
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
  }

  private function processCollectionRequest(string $method): void
  {
    switch ($method) {
      case "GET":
        echo json_encode($this->gateway->getAll());
        break;
      case "POST":
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $this->gateway->create($data);

        echo json_encode([
          "message" => "Pergunta Editada por criada",
        ]);
        break;
    }
  }
}
