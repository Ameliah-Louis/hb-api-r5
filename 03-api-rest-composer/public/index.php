<?php

// Point d'entrée de mon application
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use App\Config\Db;
use App\Config\ExceptionHandler;

// --- INITIALISATION ---

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

ExceptionHandler::registerHandler();
$pdo = Db::getPdoInstance();

// --- ROUTAGE DE LA REQUÊTE ---

$uri = $_SERVER['REQUEST_URI'];
$httpMethod = $_SERVER['REQUEST_METHOD'];

// Décomposer mon URI afin d'identifier la ressource et l'opération à effectuer
$uriParts = explode("/", $uri);
// ['', 'api', 'products', '18']

header('Content-type: application/json; charset=UTF-8');

// Collection - Lecture
if ($uri === '/api/products' && $httpMethod === "GET") {
  $stmt = $pdo->query("SELECT * FROM product");
  $results = [];
  while ($product = $stmt->fetch()) {
    $results[] = [
      'uri'   => '/api/products/' . $product['id'],
      'id'    => $product['id'],
      'name'  => $product['name'],
      'price' => $product['price']
    ];
  }
  echo json_encode($results);
  exit;
}

// Collection - Ajout
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
  exit;
}

// Analyse présence d'un ID, gestion d'erreur si ID incorrect
if (count($uriParts) === 4) {
  $id = intval($uriParts[3]);
  if ($id === 0) {
    http_response_code(404);
    echo json_encode([
      'error' => [
        'code' => 404,
        'message' => 'Product not found'
      ]
    ]);
    exit;
  }
}

// id correct
// Élément - Lecture
if ($httpMethod === 'GET') {
  $stmt = $pdo->prepare("SELECT * FROM product WHERE id=:id");
  $stmt->execute(['id' => $id]);

  $product = $stmt->fetch();

  if ($product === false) {
    http_response_code(404);
    echo json_encode([
      'error' => [
        'code' => 404,
        'message' => 'Product not found'
      ]
    ]);
    exit;
  }

  echo json_encode([
    'uri'   => '/api/products/' . $product['id'],
    'id'    => $product['id'],
    'name'  => $product['name'],
    'price' => $product['price']
  ]);
  exit;
}

// Update...
// Delete...
