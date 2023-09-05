<?php

require_once 'functions.php';

$pdo = getConnection();
$productsStmt = $pdo->query("SELECT * FROM product");
$products = $productsStmt->fetchAll();

header('Content-type: application/json; charset=UTF-8');

echo json_encode($products);
