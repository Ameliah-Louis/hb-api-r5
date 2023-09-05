<?php

function getConnection(): PDO
{
  [
    'DB_HOST' => $host,
    'DB_NAME' => $dbname,
    'DB_PORT' => $port,
    'DB_USER' => $user,
    'DB_PASSWORD' => $password,
    'DB_CHARSET' => $charset
  ] = parse_ini_file(__DIR__ . '/db.ini');

  try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $user, $password, [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    return $pdo;
  } catch (PDOException) {
    echo "Erreur lors de la connexion à la BDD";
    exit;
  }
}
