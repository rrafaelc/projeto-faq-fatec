<?php

class Database
{
  private  $host;
  private  $name;
  private  $user;
  private  $password;
  private  $port;

  public function __construct(
    string $host,
    string $name,
    string $user,
    string $password,
    string $port
  ) {
    $this->host = $host;
    $this->name = $name;
    $this->user = $user;
    $this->password = $password;
    $this->port = $port;
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
