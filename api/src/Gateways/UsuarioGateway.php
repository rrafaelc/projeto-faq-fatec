<?php

class UsuarioGateway
{
  private PDO $conn;

  public function __construct(Database $database)
  {
    $this->conn = $database->getConnection();
  }

  public function getCount()
  {
    $sql = "SELECT COUNT(*) AS total FROM usuario";
    $stmt = $this->conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return (int) $result['total'];
  }

  public function getAll($pagina = 1, $qtdPorPg = 10, $order = "asc")
  {
    $sql = "SELECT COUNT(*) AS qtd_pg FROM usuario";
    $stmt = $this->conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $qtd_pg = ceil($result["qtd_pg"] / $qtdPorPg);

    $offset = ($pagina - 1) * $qtdPorPg;

    $order = strtoupper($order);
    if ($order != "ASC" && $order != "DESC") {
      $order = "ASC";
    }

    $sql = "SELECT * FROM usuario
            ORDER BY id $order LIMIT :limit OFFSET :offset";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":limit", $qtdPorPg, PDO::PARAM_INT);
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();

    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $row["esta_suspenso"] = (bool) $row["esta_suspenso"];
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
            FROM usuario
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data !== false) {
      $data["esta_suspenso"] = (bool) $data["esta_suspenso"];
    }

    return $data;
  }

  public function getByEmail(string $email)
  {
    $sql = "SELECT *
            FROM usuario
            WHERE email = :email";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data !== false) {
      $data["esta_suspenso"] = (bool) $data["esta_suspenso"];
    }

    return $data;
  }

  public function create(array $data)
  {
    $sql = "INSERT INTO usuario (nome_completo, email, foto_uri, senha, cargo)
            VALUES (:nome_completo, :email, :foto_uri, :senha, :cargo)";

    $hashSenha = password_hash($data["senha"], PASSWORD_DEFAULT);

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":nome_completo", $data["nome_completo"], PDO::PARAM_STR);
    $stmt->bindValue(":email", $data["email"], PDO::PARAM_STR);
    $stmt->bindValue(":foto_uri", $data["foto_uri"] ?? NULL, PDO::PARAM_STR);
    $stmt->bindValue(":senha", $hashSenha, PDO::PARAM_STR);
    $stmt->bindValue(":cargo", $data["cargo"] ?? "Moderador", PDO::PARAM_STR);
    $stmt->execute();
    $usuarioId = $this->conn->lastInsertId();


    $sql = "SELECT * FROM usuario WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $usuarioId, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario !== false) {
      $usuario["esta_suspenso"] = (bool) $usuario["esta_suspenso"];
    }

    return $usuario;
  }

  public function update(array $current, array $new)
  {
    $sql = "UPDATE usuario
            SET nome_completo = :nome_completo, email = :email, foto_uri = :foto_uri, senha = :senha
            WHERE id = :id";

    $hashSenha = isset($new["senha"]) ? password_hash($new["senha"], PASSWORD_DEFAULT) : $current["senha"];

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":nome_completo", $new["nome_completo"] ?? $current["nome_completo"], PDO::PARAM_STR);
    $stmt->bindValue(":email", $new["email"] ?? $current["email"], PDO::PARAM_STR);
    $stmt->bindValue(":foto_uri", $new["foto_uri"] ?? $current["foto_uri"] ?? null, PDO::PARAM_STR);
    $stmt->bindValue(":senha", $hashSenha, PDO::PARAM_STR);

    $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
    $stmt->execute();

    $sql = "SELECT * FROM usuario WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario !== false) {
      $usuario["esta_suspenso"] = (bool) $usuario["esta_suspenso"];
    }

    return $usuario;
  }

  public function updateCargo(string $cargo, string $id)
  {
    $sql = "UPDATE usuario
            SET cargo = :cargo
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":cargo", $cargo, PDO::PARAM_STR);

    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function delete(string $id)
  {
    $sql = "DELETE FROM usuario
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function updateSuspensao(bool $suspender, string $id)
  {
    $sql = "UPDATE usuario
            SET esta_suspenso = :esta_suspenso, access_token = :access_token, refresh_token = :refresh_token, refresh_token_expiration = :refresh_token_expiration
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":esta_suspenso", $suspender, PDO::PARAM_BOOL);
    $stmt->bindValue(":access_token", null, PDO::PARAM_STR);
    $stmt->bindValue(":refresh_token", null, PDO::PARAM_STR);
    $stmt->bindValue(":refresh_token_expiration", null, PDO::PARAM_STR);

    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function updateToken(?string $access_token, ?string $refresh_token, ?string $expiration_date, string $id)
  {
    $sql = "UPDATE usuario
            SET access_token = :access_token, refresh_token = :refresh_token, refresh_token_expiration = :refresh_token_expiration
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":access_token", $access_token, PDO::PARAM_STR);
    $stmt->bindValue(":refresh_token", $refresh_token, PDO::PARAM_STR);
    $stmt->bindValue(":refresh_token_expiration", $expiration_date, PDO::PARAM_STR);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);

    $stmt->execute();
  }

  public function getByRefreshToken(string $refresh_token)
  {
    $sql = "SELECT *
            FROM usuario
            WHERE refresh_token = :refresh_token";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":refresh_token", $refresh_token, PDO::PARAM_STR);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data !== false) {
      $data["esta_suspenso"] = (bool) $data["esta_suspenso"];
    }

    return $data;
  }
}
