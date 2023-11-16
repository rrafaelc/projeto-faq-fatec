<?php

class PerguntaGateway
{
  private PDO $conn;

  public function __construct(Database $database)
  {
    $this->conn = $database->getConnection();
  }

  public function getAll(array $ordenacao): array
  {
    $sql = "SELECT p.*,
      u.id AS id_usuario,
      u.nome_completo AS nome_usuario,
      u.email AS email_usuario,
      u.foto_uri AS foto_usuario,
      ue.id AS id_usuario_editado,
      ue.nome_completo AS nome_usuario_editado,
      ue.email AS email_usuario_editado,
      ue.foto_uri AS foto_usuario_editado
      FROM pergunta p
      LEFT JOIN usuario u ON p.criado_por = u.id
      LEFT JOIN pergunta_editada_por pe ON u.id = pe.usuario_id
      LEFT JOIN usuario ue ON pe.usuario_id = ue.id";

    if (isset($ordenacao["MaisAlta"]) && $ordenacao["MaisAlta"]) {
      $sql = "SELECT p.*,
        u.id AS id_usuario,
        u.nome_completo AS nome_usuario,
        u.email AS email_usuario,
        u.foto_uri AS foto_usuario,
        ue.id AS id_usuario_editado,
        ue.nome_completo AS nome_usuario_editado,
        ue.email AS email_usuario_editado,
        ue.foto_uri AS foto_usuario_editado
        FROM pergunta p
        LEFT JOIN usuario u ON p.criado_por = u.id
        LEFT JOIN pergunta_editada_por pe ON u.id = pe.usuario_id
        LEFT JOIN usuario ue ON pe.usuario_id = ue.id
        ORDER BY
          CASE
              WHEN prioridade = 'Alta' THEN 1
              WHEN prioridade = 'Normal' THEN 2
          END;";
    }

    if (isset($ordenacao["MaisCurtidas"]) && $ordenacao["MaisCurtidas"]) {
      $sql = "SELECT p.*,
        u.id AS id_usuario,
        u.nome_completo AS nome_usuario,
        u.email AS email_usuario,
        u.foto_uri AS foto_usuario,
        ue.id AS id_usuario_editado,
        ue.nome_completo AS nome_usuario_editado,
        ue.email AS email_usuario_editado,
        ue.foto_uri AS foto_usuario_editado
        FROM pergunta p
        LEFT JOIN usuario u ON p.criado_por = u.id
        LEFT JOIN pergunta_editada_por pe ON u.id = pe.usuario_id
        LEFT JOIN usuario ue ON pe.usuario_id = ue.id
        ORDER BY curtidas DESC";
    }

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
            FROM pergunta
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data;
  }

  public function create(array $data): array | false
  {
    $prioridade = $data["prioridade"] ?? "Normal";

    // Criar a pergunta
    $sql = "INSERT INTO pergunta (pergunta, resposta, prioridade, criado_por)
            VALUES (:pergunta, :resposta, :prioridade, :criado_por)";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":pergunta", $data["pergunta"], PDO::PARAM_STR);
    $stmt->bindValue(":resposta", $data["resposta"], PDO::PARAM_STR);
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

  public function update(array $current, array $new): array | false
  {
    $sql = "UPDATE pergunta
            SET pergunta = :pergunta, resposta = :resposta, curtidas = :curtidas, prioridade = :prioridade
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":pergunta", $new["pergunta"] ?? $current["pergunta"], PDO::PARAM_STR);
    $stmt->bindValue(":resposta", $new["resposta"] ?? $current["resposta"], PDO::PARAM_STR);
    $stmt->bindValue(":curtidas", $new["curtidas"] ?? $current["curtidas"], PDO::PARAM_INT);
    $stmt->bindValue(":prioridade", $new["prioridade"] ?? $current["prioridade"], PDO::PARAM_STR);

    $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
    $stmt->execute();

    # atualiza o usuario onde o id da tabela pergunta_editada_por seja igual a pergunta_id
    $sql = "UPDATE pergunta_editada_por
            SET usuario_id = :usuario_id
            WHERE pergunta_id = :pergunta_id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":pergunta_id", $current["id"], PDO::PARAM_INT);
    $stmt->bindValue(":usuario_id", $new["usuarioId"], PDO::PARAM_INT);
    $stmt->execute();

    // Consulta a pergunta recém-atualizada
    $sql = "SELECT * FROM pergunta WHERE id = :pergunta_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":pergunta_id", $current["id"], PDO::PARAM_INT);
    $stmt->execute();
    $pergunta = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retorna a pergunta atualizada
    return $pergunta;
  }

  public function delete(string $id): void
  {
    $sql = "DELETE FROM pergunta
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function updateCurtidas(array $current, array $new): array | false
  {
    $sql = "UPDATE pergunta
            SET curtidas = :curtidas
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":curtidas", $new["curtidas"] ?? $current["curtidas"], PDO::PARAM_INT);

    $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
    $stmt->execute();

    $sql = "SELECT * FROM pergunta WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
    $stmt->execute();
    $pergunta = $stmt->fetch(PDO::FETCH_ASSOC);

    return $pergunta;
  }
}
