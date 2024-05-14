<?php

require_once __DIR__ . '/../services/BarberService.class.php';

$barber_id = $_REQUEST['id'];

if($barber_id == NULL || $barber_id == '') {
    header("HTTP/1.1 500 Bad Request");
    die(json_encode(['error' => "You have to provide a vaild barber id!"]));
}

$barber_service = new BarberService();
$barber_service -> delete_barber_by_id($barber_id);
echo json_encode(['message' => 'You have successfully deleted a barber!']);