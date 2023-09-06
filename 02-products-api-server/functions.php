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

/**
 * Deletes a product
 *
 * @param PDO $pdo
 * @param integer $id
 * @return integer Number of deleted rows
 */
function deleteProduct(PDO $pdo, int $id): int
{
  $stmtDelete = $pdo->prepare('DELETE FROM product WHERE id=:id');
  $stmtDelete->execute(['id' => $id]);

  $affectedRows = $stmtDelete->rowCount();
  return $affectedRows;
}
