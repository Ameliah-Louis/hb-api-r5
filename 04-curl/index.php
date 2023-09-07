<?php

// Création du handler
$client = curl_init("https://jsonplaceholder.typicode.com/users");

// Définition des options
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

// Exécution de la requête
$response = curl_exec($client);
$data = json_decode($response, true);

header("Content-type: application/json; charset=UTF-8");

echo json_encode($data);

// Fermer le handler
curl_close($client);
