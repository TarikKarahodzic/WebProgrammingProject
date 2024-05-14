<?php

require_once __DIR__ . '/../services/BarberService.class.php';

$payload = $_REQUEST;

//add
if($payload['full_name'] == NULL || $payload['full_name'] == '') {
    header('HTTP/1.1 500 Bad Request');
    die(json_encode(['error' => 'Full name field is missing']));
}

$barber_service = new BarberService();

//update
if($payload['barber_id'] != NULL && $payload['barber_id'] != '') {
    $barber = $barber_service -> edit_barber($payload);
} else {
    unset($payload['barber_id']);
    $barber = $barber_service -> add_barber($payload);
}

echo json_encode(['message' => 'You have successfully added the barber', 'data' => $barber]);