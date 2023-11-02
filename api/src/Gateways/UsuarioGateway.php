<?php

class UsuarioGateway
{
  private PDO $conn;

  public function __construct(Database $database)
  {
    $this->conn = $database->getConnection();
  }

  public function getCount(): int
  {
    $sql = "SELECT COUNT(*) AS total FROM usuario";
    $stmt = $this->conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return (int) $result['total'];
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

  public function get(string $id): array | false
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

  public function getByRa(string $ra): array | false
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

  public function getByEmail(string $email): array | false
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

  public function update(array $current, array $new): array | false
  {
    $sql = "UPDATE usuario
            SET nome_completo = :nome_completo, ra = :ra, email = :email, foto_uri = :foto_uri, senha = :senha, cargo = :cargo
            WHERE id = :id";

    $hashSenha = isset($new["senha"]) ? password_hash($new["senha"], PASSWORD_DEFAULT) : $current["senha"];

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":nome_completo", $new["nome_completo"] ?? $current["nome_completo"], PDO::PARAM_STR);
    $stmt->bindValue(":ra", $new["ra"] ?? $current["ra"], PDO::PARAM_STR);
    $stmt->bindValue(":email", $new["email"] ?? $current["email"], PDO::PARAM_STR);
    $stmt->bindValue(":foto_uri", $new["foto_uri"] ?? $current["foto_uri"] ?? null, PDO::PARAM_STR);
    $stmt->bindValue(":senha", $hashSenha, PDO::PARAM_STR);
    $stmt->bindValue(":cargo", $new["cargo"] ?? $current["cargo"], PDO::PARAM_STR);

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

  public function delete(string $id): void
  {
    $sql = "DELETE FROM usuario
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function updateSuspensao(bool $suspender, string $id): void
  {
    $sql = "UPDATE usuario
            SET esta_suspenso = :esta_suspenso
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":esta_suspenso", $suspender, PDO::PARAM_BOOL);

    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function updateToken(?string $access_token, ?string $refresh_token, ?string $expiration_date, string $id): void
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

  public function getByRefreshToken(string $refresh_token): array | false
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
