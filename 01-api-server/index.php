<?php

require_once 'data/users.php';

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

echo json_encode($users);
