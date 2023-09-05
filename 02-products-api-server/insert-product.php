<?php

require_once 'functions.php';

$pdo = getConnection();

header('Content-type: application/json; charset=UTF-8');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

var_dump($data);
