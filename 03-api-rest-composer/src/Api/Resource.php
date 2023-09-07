<?php

namespace App\Api;

use App\Config\Db;

abstract class Resource
{
  protected string $resourcePrefix = '/api';
  protected string $resourceName;
  protected string $tableName;
  protected \PDO $pdo;

  public function __construct()
  {
    $this->pdo = Db::getPdoInstance();
  }

  public function getAll(): array
  {
    $stmt = $this->pdo->query("SELECT * FROM " . $this->tableName);
    return $stmt->fetchAll();
  }
  //...
}
