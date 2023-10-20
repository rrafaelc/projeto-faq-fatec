<?php

class UsuarioGateway
{
  private PDO $conn;

  public function __construct(Database $database)
  {
    $this->conn = $database->getConnection();
  }

  public function getAll(): array
  {
    $sql = "SELECT *
            FROM usuario";

    $stmt = $this->conn->query($sql);

    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $row["esta_suspenso"] = (bool) $row["esta_suspenso"];
      $data[] = $row;
  }

    return $data;
  }

  public function create(array $data): array | false
  {
    $sql = "INSERT INTO usuario (nome_completo, ra, email, foto_uri, senha, cargo)
            VALUES (:nome_completo, :ra, :email, :foto_uri, :senha, :cargo)";

    $hashSenha = password_hash($data["senha"], PASSWORD_DEFAULT);

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":nome_completo", $data["nome_completo"], PDO::PARAM_STR);
    $stmt->bindValue(":ra", $data["ra"], PDO::PARAM_STR);
    $stmt->bindValue(":email", $data["email"], PDO::PARAM_STR);
    $stmt->bindValue(":foto_uri", $data["foto_uri"] ?? NULL, PDO::PARAM_STR);
    $stmt->bindValue(":senha", $hashSenha, PDO::PARAM_STR);
    $stmt->bindValue(":cargo", $data["cargo"] ?? "Colaborador", PDO::PARAM_STR);
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

  public function getByRa(string $ra)
  {
    $sql = "SELECT *
            FROM usuario
            WHERE ra = :ra";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":ra", $ra, PDO::PARAM_STR);
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

  public function update(array $current, array $new)
  {
    $sql = "UPDATE usuario
            SET nome_completo = :nome_completo, ra = :ra, email = :email, foto_uri = :foto_uri, senha = :senha, cargo = :cargo, esta_suspenso = :esta_suspenso)
            WHERE id = :id";

    $hashSenha = $new["senha"] ? password_hash($new["senha"], PASSWORD_DEFAULT) : $current["senha"];

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":nome_completo", $new["nome_completo"] ?? $current["nome_completo"], PDO::PARAM_STR);
    $stmt->bindValue(":ra", $new["ra"] ?? $current["ra"], PDO::PARAM_STR);
    $stmt->bindValue(":email", $new["email"] ?? $current["email"], PDO::PARAM_STR);
    $stmt->bindValue(":foto_uri", $new["foto_uri"] ?? $current["foto_uri"] ?? null, PDO::PARAM_STR);
    $stmt->bindValue(":senha", $hashSenha, PDO::PARAM_STR);
    $stmt->bindValue(":cargo", $new["cargo"] ?? $current["cargo"], PDO::PARAM_STR);
    $stmt->bindValue(":esta_suspenso", (bool) $new["esta_suspenso"] ?? (bool) $current["esta_suspenso"] ?? false, PDO::PARAM_BOOL);

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

  public function delete(string $id)
  {
    $sql = "DELETE FROM usuario
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }
}
