<?php

require_once 'functions.php';
require_once 'Response.php';

$pdo = getConnection();

header('Content-type: application/json; charset=UTF-8');

// Récupération de l'ID
$id = $_GET['id'];

$rowCount = deleteProduct($pdo, intval($id));

if ($rowCount === 0) {
  http_response_code(Response::NOT_FOUND);
  exit;
}

http_response_code(Response::NO_CONTENT);
