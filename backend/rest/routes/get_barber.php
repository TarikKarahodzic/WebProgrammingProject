<?php

require_once __DIR__ . '/../services/BarberService.class.php';

$barber_id = $_REQUEST['id'];

$barber_service = new BarberService();
$barber = $barber_service->get_barber_by_id($barber_id);

header('Content-Type: application/json');
echo json_encode($barber);