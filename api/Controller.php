<?php

namespace Web;

use OpenApi\Annotations as OA;
use Flight as Flight;

require_once __DIR__ . '/../backend/rest/services/BarberService.class.php';

FLight::set('barber_service', new \BarberService());

Flight::group('/barbers', function () {
    /**
     * @OA\Get(
     *      path="/barbers/all",
     *      summary="Get all barbers",
     *      tags={"Barbers"},
     *      @OA\Response(
     *          response=200,
     *          description="Array of all barbers in the database"
     *      ),
     *  )
     */
    Flight::route('GET /all', function () {
        $data = Flight::get('barber_service')->get_all_barbers();
        Flight::json($data, 200);
    });

    /*Flight::route('GET /', function () {
        $payload = Flight::request() -> query;

        $params = [
            'start' => (int)$payload['start'],
            'search' => $payload['search']['value'],
            'draw' => $payload['draw'],
            'limit' => (int)$payload['length'],
            'order_column' => $payload['order'][0]['name'],
            'order_direction' => $payload['order'][0]['dir'],
        ];

        $data = Flight::get('barber_service') -> get_barbers_paginated($params['start'], $params['limit'], $params['search'], $params['order_column'], $params['order_direction']);

        foreach ($data['data'] as $id => $barber) {
            $data['data'][$id]['action'] = '<div class="btn-group" role="group" aria-label="Actions">' .
                                                '<button type="button" class="btn btn-warning" onclick="BarberService.open_edit_barber_modal('. $barber['barber_id'] .')">Edit</button>' .
                                                '<button type="button" class="btn btn-danger" onclick="BarberService.delete_barber_modal('. $barber['barber_id'] .')">Delete</button>'  .
                                            '</div>';
        }
    });*/
});


