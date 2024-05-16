<?php
require_once __DIR__ . '/../services/BarberService.class.php';

$payload = $_REQUEST;

$params = [
    'start' => (int)$payload['start'],
    'search' => $payload['search']['value'],
    'draw' => $payload['draw'],
    'limit' => (int)$payload['length'],
    'order_column' => $payload['order'][0]['name'],
    'order_direction' => $payload['order'][0]['dir'],
];

$barber_service = new BarberService();

$data = $barber_service->get_barbers_paginated($params['start'], $params['limit'], $params['search'], $params['order_column'], $params['order_direction']);

foreach ($data['data'] as $id => $barber) {
    $data['data'][$id]['action'] = '<div class="btn-group" role="group" aria-label="Actions">' .
                                        '<button type="button" class="btn btn-warning" onclick="BarberService.open_edit_barber_modal('. $barber['barber_id'] .')">Edit</button>' .
                                        '<button type="button" class="btn btn-danger" onclick="BarberService.delete_barber_modal('. $barber['barber_id'] .')">Delete</button>'  .
                                    '</div>';
}

// Response
echo json_encode([
    'draw' => $params['draw'],
    'data' => $data['data'],
    'recordsFiltered' => $data['count'],
    'recordsTotal' => $data['count'],
    'end' => $data['count']
]);
