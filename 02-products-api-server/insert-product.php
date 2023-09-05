<?php

require_once 'functions.php';
require_once 'Response.php';

set_exception_handler(function (Throwable $ex): void {
  http_response_code(Response::INTERNAL_SERVER_ERROR);
  echo json_encode([
    'error' => [
      'code' => $ex->getCode(),
      'message' => "Une erreur est survenue"
    ]
  ]);
});

$pdo = getConnection();

header('Content-type: application/json; charset=UTF-8');

// J'extraie les données du corps de la requête
$json = file_get_contents('php://input');
// Je décode les données extraites
// De JSON à un tableau associatif PHP
$data = json_decode($json, true);

// $data est à présent un tableau associatif
// indexé sur les propriétés de l'objet JSON transmis

// Je vais donc utiliser les valeurs qui se trouvent derrière
// les clés "name" et "price"
// pour préparer un statement INSERT, puis l'exécuter avec ces valeurs
$insertStmt = $pdo->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
$insertStmt->execute([$data['name'], $data['price']]);

// Rechercher un code de réponse HTTP adapté en cas de succès de création
http_response_code(Response::CREATED);

// Puis, dans le corps de la réponse, renvoyer le produit créé, avec son ID
$productId = $pdo->lastInsertId();

echo json_encode([
  'id' => intval($productId),
  ...$data
]);
