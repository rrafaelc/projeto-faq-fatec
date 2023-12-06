<?php

class PerguntaSugeridaGateway
{
  private PDO $conn;

  public function __construct(Database $database)
  {
    $this->conn = $database->getConnection();
  }

  public function getAll($pagina = 1, $qtdPorPg = 10, $order = "asc", $trazerRespondidas = false): array
  {
    if (!$trazerRespondidas) {
      $sql = "SELECT COUNT(*) AS qtd_pg FROM pergunta_sugerida WHERE foi_respondido = 0";
    } else {
      $sql = "SELECT COUNT(*) AS qtd_pg FROM pergunta_sugerida";
    }
    $stmt = $this->conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $qtd_pg = ceil($result["qtd_pg"] / $qtdPorPg);

    $offset = ($pagina - 1) * $qtdPorPg;

    $order = strtoupper($order);
    if ($order != "ASC" && $order != "DESC") {
      $order = "ASC";
    }

    if (!$trazerRespondidas) {
      $sql = "SELECT * FROM pergunta_sugerida WHERE foi_respondido = 0 ORDER BY id $order LIMIT :limit OFFSET :offset";
    } else {
      $sql = "SELECT * FROM pergunta_sugerida ORDER BY id $order LIMIT :limit OFFSET :offset";
    }
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":limit", $qtdPorPg, PDO::PARAM_INT);
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();

    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $data[] = $row;
    }

    return [
      "pagina" => intval($pagina),
      "qtd_pg" => $qtd_pg,
      "total" => $result["qtd_pg"],
      "resultado" => $data
    ];
  }

  public function get(string $id)
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

  public function create(array $data)
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

  public function delete(string $id)
  {
    $sql = "DELETE FROM pergunta_sugerida
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }
}
