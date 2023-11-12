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
    $sql = "INSERT INTO pergunta_sugerida (nome, pergunta, email, telefone) VALUES (:nome, :pergunta, :email, :telefone)";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":nome", $data["nome"], PDO::PARAM_STR);
    $stmt->bindValue(":pergunta", $data["pergunta"], PDO::PARAM_STR);
    $stmt->bindValue(":email", $data["email"], PDO::PARAM_STR);
    $stmt->bindValue(":telefone", $data["telefone"], PDO::PARAM_STR);
    $stmt->execute();

    $perguntaSugeridaId = $this->conn->lastInsertId();

    $sql = "SELECT * FROM pergunta_sugerida WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $perguntaSugeridaId, PDO::PARAM_INT);
    $stmt->execute();
    $perguntaSugerida = $stmt->fetch(PDO::FETCH_ASSOC);

    return $perguntaSugerida;
  }

  public function update(string $id, string $userId)
  {
    $sql = "UPDATE pergunta_sugerida
            SET respondido_por = :respondido_por, foi_respondido = :foi_respondido
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":respondido_por", $userId, PDO::PARAM_INT);
    $stmt->bindValue(":foi_respondido", true, PDO::PARAM_BOOL);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "SELECT * FROM pergunta_sugerida WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $perguntaSugerida = $stmt->fetch(PDO::FETCH_ASSOC);

    return $perguntaSugerida;
  }
}
