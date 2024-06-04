<?php

require __DIR__ . '/../../vendor/autoload.php';

/**
 * @OA\Get(
 *      path="/api/appointments",
 *      tags={"appointments"},
 *      summary="Get all appointments",
 *      @OA\Response(
 *           response=200,
 *           description="Appointments list"
 *      )
 * )
 */

Flight::route('GET /api/appointments', function () {
    Flight::json(Flight::appointmentService()->get_all());
});

/**
 * @OA\Get(
 *      path="/api/appointments/{id}",
 *      tags={"appointments"},
 *      summary="Get appointment by id",
 *      @OA\Response(
 *           response=200,
 *           description="Appointment data, false if the appointment does not exist"
 *      ),
 *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="appointment ID")
 * )
 */

Flight::route('GET /api/appointments/@id', function ($id) {
    Flight::json(Flight::appointmentService()->getById($id));
});

/**
 * @OA\Post(
 *      path="/api/appointments",
 *      tags={"appointments"},
 *      summary="Add appointments data to the database",
 *      @OA\Response(
 *           response=200,
 *           description="appointments data, or exception if appointments is not added properly"
 *      ),
 *      @OA\RequestBody(
 *          description="appointment data payload",
 *          @OA\JsonContent(
 *              required={"user_id","barber_id","service_id", "appointment_time"},
 *              @OA\Property(property="user_id", type="string", example="1", description="users id"),
 *              @OA\Property(property="barber_id", type="string", example="2", description="barbers id"),
 *              @OA\Property(property="service_id", type="string", example="1", description="service id"),
 *              @OA\Property(property="appointment_time", type="string", example="YYYY:MM:DD hh:mm:ss", description="appointment time"),
 *          )
 *      )
 * )
 */

Flight::route('POST /api/appointments', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::appointmentService()->add($data));
});

/**
 * @OA\Post(
 *      path="/api/appointments_add",
 *      tags={"appointments"},
 *      summary="Add appointments data to the database",
 *      @OA\Response(
 *           response=200,
 *           description="appointments data, or exception if appointments is not added properly"
 *      ),
 *      @OA\RequestBody(
 *          description="appointment data payload",
 *          @OA\JsonContent(
 *              required={"user_id","barber_id","service_id", "appointment_time"},
 *              @OA\Property(property="user_id", type="string", example="1", description="users id"),
 *              @OA\Property(property="barber_id", type="string", example="2", description="barbers id"),
 *              @OA\Property(property="service_id", type="string", example="1", description="service id"),
 *              @OA\Property(property="appointment_time", type="string", example="YYYY:MM:DD hh:mm:ss", description="appointment time"),
 *          )
 *      )
 * )
 */

 Flight::route('POST /api/appointments_add', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::appointmentService()->add_date($data));
});


/**
 * @OA\Put(
 *      path="/api/appointments/{id}",
 *      tags={"appointments"},
 *      summary="Update appointments data by id",
 *      @OA\Response(
 *           response=200,
 *           description="Updated appointments data, or 500 status code exception"
 *      ),
 *      @OA\Parameter(@OA\Schema(type="nubmer"), in="path", name="id", example="1", description="Appointment id"),
 *      @OA\RequestBody(
 *          description="Appointment data payload",
 *          @OA\JsonContent(
 *              required={"user_id","barber_id","service_id", "appointment_time"},
 *              @OA\Property(property="user_id", type="string", example="1", description="users id"),
 *              @OA\Property(property="barber_id", type="string", example="2", description="barbers id"),
 *              @OA\Property(property="service_id", type="string", example="1", description="service id"),
 *              @OA\Property(property="appointment_time", type="string", example="11:00", description="appointment time"),
 *          )
 *      )
 * )
 */

Flight::route('PUT /api/appointments/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::appointmentService()->update($id, $data);
    Flight::json(Flight::appointmentService()->getById($id));
});

/**
 * @OA\Delete(
 *      path="/api/appointments/{id}",
 *      tags={"appointments"},
 *      summary="Delete appointment by id",
 *      @OA\Parameter(@OA\Schema(type="nubmer"), in="path", name="id", example="1", description="appointment id"),
 *      @OA\Response(
 *           response=200,
 *           description="Deleted appointment data or 500 status code exception otherwise"
 *      ),
 * )
 */

Flight::route('DELETE /api/appointments/@id', function ($id) {
    Flight::appointmentService()->delete($id);
});
