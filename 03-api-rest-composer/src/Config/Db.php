<?php

namespace App\Config;

use PDO;

class Db
{
  private function __construct()
  {
  }

  private static ?PDO $pdoInstance = null;
  public static function getPdoInstance(): PDO
  {
    if (self::$pdoInstance === null) {
      [
        'DB_HOST' => $host,
        'DB_NAME' => $dbname,
        'DB_PORT' => $port,
        'DB_USER' => $user,
        'DB_PASSWORD' => $password,
        'DB_CHARSET' => $charset
      ] = $_ENV;

      $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
      self::$pdoInstance = new PDO($dsn, $user, $password, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);
    }

    return self::$pdoInstance;
  }
}
