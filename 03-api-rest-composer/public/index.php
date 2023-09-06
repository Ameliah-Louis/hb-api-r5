<?php

// Point d'entrée de mon application
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use App\Config\Db;
use App\Config\ExceptionHandler;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

ExceptionHandler::registerHandler();
$pdo = Db::getPdoInstance();

$uri = $_SERVER['REQUEST_URI'];
$httpMethod = $_SERVER['REQUEST_METHOD'];

// Décomposer mon URI afin d'identifier la ressource et l'opération à effectuer
$uriParts = explode("/", $uri);
var_dump($uriParts);
// Analyser uriParts de la façon suivante :
// Combien ai-je de parties dans mon URL ? 3 ? 4 ? Alors peut-être que le client essaye d'accéder à une ressource seule plutôt qu'à une collection
// Si le client tente d'accéder à un élément seul, alors il faut que je valide que l'ID demandé est correct

header('Content-type: application/json; charset=UTF-8');

if ($uri === '/api/products' && $httpMethod === "GET") {
  $stmt = $pdo->query("SELECT * FROM product");
  echo json_encode($stmt->fetchAll());
}

if ($uri === '/api/products' && $httpMethod === "POST") {
  $data = json_decode(file_get_contents(filename: 'php://input'), true);
  $stmt = $pdo->prepare("INSERT INTO product (name, price) VALUES (?, ?)");
  $stmt->execute([$data['name'], $data['price']]);

  http_response_code(201);
  $productId = $pdo->lastInsertId();

  echo json_encode([
    'uri' => '/api/products/' . $productId,
    'id' => $productId,
    'name' => $data['name'],
    'price' => $data['price']
  ]);
}
