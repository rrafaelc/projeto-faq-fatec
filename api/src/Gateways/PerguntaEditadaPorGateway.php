<?php

class PerguntaEditadaPorGateway
{
  private PDO $conn;

  public function __construct(Database $database)
  {
    $this->conn = $database->getConnection();
  }

  public function getAll(): array
  {
    $sql = "SELECT *
            FROM pergunta_editada_por";

    $stmt = $this->conn->query($sql);

    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $data[] = $row;
    }

    return $data;
  }

  public function create(array $data): string
  {
    $sql = "INSERT INTO pergunta_editada_por (pergunta_id, usuario_id)
            VALUES (:pergunta_id, :usuario_id)";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindValue(":pergunta_id", $data["pergunta_id"], PDO::PARAM_STR);
    $stmt->bindValue(":usuario_id", $data["usuario_id"], PDO::PARAM_STR);

    $stmt->execute();

    $stmt = $this->conn->query("SELECT UUID()");
    $id = $stmt->fetchColumn();

    return $id;
  }
}
