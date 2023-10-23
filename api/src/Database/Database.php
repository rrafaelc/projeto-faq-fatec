<?php

class Database
{
  public function __construct(
    private string $host,
    private string $name,
    private string $user,
    private string $password,
    private string $port,
  ) {
  }

  public function getConnection(): PDO
  {
    $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->name};charset=utf8";

    return new PDO($dsn, $this->user, $this->password, [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_STRINGIFY_FETCHES => false
    ]);
  }
}
