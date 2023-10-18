<?php

class PerguntaGateway
{
  private PDO $conn;

  public function __construct(Database $database)
  {
    $this->conn = $database->getConnection();
  }

  public function getAll(): array
  {
    $sql = "SELECT *
            FROM pergunta";

    $stmt = $this->conn->query($sql);

    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      // $row["is_available"] = (bool) $row["is_available"];

      $data[] = $row;
    }

    return $data;
  }

  public function create(array $data): array | false
  {
    $prioridade = "Normal";

    // Criar a pergunta
    $sql = "INSERT INTO pergunta (pergunta, resposta, prioridade, criado_por)
            VALUES (:pergunta, :resposta, :prioridade, :criado_por)";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":pergunta", $data["pergunta"], PDO::PARAM_STR);
    $stmt->bindValue(":resposta", $data["resposta"], PDO::PARAM_STR);
    // $stmt->bindValue(":size", $data["size"] ?? 0, PDO::PARAM_INT);
    // $stmt->bindValue(":is_available", (bool) $data["is_available"] ?? false, PDO::PARAM_BOOL);
    $stmt->bindValue(":prioridade",  $prioridade, PDO::PARAM_STR);
    $stmt->bindValue(":criado_por", $data["usuarioId"], PDO::PARAM_INT);
    $stmt->execute();
    $perguntaId = $this->conn->lastInsertId();

    # Insere o id da pergunta e do usuario a tabela pergunta_editada_por
    $sql = "INSERT INTO pergunta_editada_por (pergunta_id, usuario_id)
            VALUES (:pergunta_id, :usuario_id)";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":pergunta_id", $perguntaId, PDO::PARAM_INT);
    $stmt->bindValue(":usuario_id", $data["usuarioId"], PDO::PARAM_INT);
    $stmt->execute();

    // Consulta a pergunta recém-criada
    $sql = "SELECT * FROM pergunta WHERE id = :pergunta_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":pergunta_id", $perguntaId, PDO::PARAM_INT);
    $stmt->execute();
    $pergunta = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retorna a pergunta criada
    return $pergunta;
  }

  public function get(string $id): array | false
  {
    $sql = "SELECT *
            FROM pergunta
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // if ($data !== false) {
    //   $data["is_available"] = (bool) $data["is_available"];
    // }

    return $data;
  }
}
