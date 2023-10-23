<?php

class PerguntaSugeridaGateway
{
  private PDO $conn;

  public function __construct(Database $database)
  {
    $this->conn = $database->getConnection();
  }

  public function getAll(): array
  {
    $sql = "SELECT *
            FROM pergunta_sugerida";

    $stmt = $this->conn->query($sql);

    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $data[] = $row;
    }

    return $data;
  }

  public function get(string $id): array | false
  {
    $sql = "SELECT *
            FROM pergunta_sugerida
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data;
  }

  public function create(array $data): array | false
  {
    $sql = "INSERT INTO pergunta_sugerida (nome, pergunta) VALUES (:nome, :pergunta)";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":nome", $data["nome"], PDO::PARAM_STR);
    $stmt->bindValue(":pergunta", $data["pergunta"], PDO::PARAM_STR);
    $stmt->execute();

    $perguntaSugeridaId = $this->conn->lastInsertId();

    $sql = "SELECT * FROM pergunta_sugerida WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $perguntaSugeridaId, PDO::PARAM_INT);
    $stmt->execute();
    $perguntaSugerida = $stmt->fetch(PDO::FETCH_ASSOC);

    return $perguntaSugerida;
  }

  public function delete(string $id): void
  {
    $sql = "DELETE FROM pergunta_sugerida
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }
}
