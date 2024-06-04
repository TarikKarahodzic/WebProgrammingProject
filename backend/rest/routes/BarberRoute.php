<?php

require __DIR__ . '/../../vendor/autoload.php';

/**
 * @OA\Get(
 *      path="/api/barbers",
 *      tags={"barbers"},
 *      summary="Get all barbers",
 *      @OA\Response(
 *           response=200,
 *           description="Barbers list"
 *      )
 * )
 */

Flight::route('GET /api/barbers', function () {
    Flight::json(Flight::barberService()->get_all());
});

/**
 * @OA\Get(
 *      path="/api/barbers/{id}",
 *      tags={"barbers"},
 *      summary="Get barber by id",
 *      @OA\Response(
 *           response=200,
 *           description="Barber data, false if the barber does not exist"
 *      ),
 *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Barber ID")
 * )
 */

Flight::route('GET /api/barbers/@id', function ($id) {
    Flight::json(Flight::barberService()->getById($id));
});

/**
 * @OA\Post(
 *      path="/api/barbers",
 *      tags={"barbers"},
 *      summary="Add barbers data to the database",
 *      @OA\Response(
 *           response=200,
 *           description="barbers data, or exception if barbers is not added properly"
 *      ),
 *      @OA\RequestBody(
 *          description="Barber data payload",
 *          @OA\JsonContent(
 *              required={"barber_name","barber_phoneNumber","barber_email", "barber_password", "work_start_time", "work_end_time", "days_off"},
 *              @OA\Property(property="barber_name", type="string", example="John Dao", description="Barbers' full name"),
 *              @OA\Property(property="barber_phoneNumber", type="string", example="+38761222333", description="Barbers' phone number"),
 *              @OA\Property(property="barber_email", type="string", example="johndoe@example.com", description="Barbers' email"),
 *              @OA\Property(property="barber_password", type="string", example="Password", description="Barbers' password"),
 *              @OA\Property(property="work_start_time", type="string", example="08:00:00", description="Barbers' shift start"),
 *              @OA\Property(property="work_end_time", type="string", example="16:00:00", description="Barbers' end of shift"),
 *              @OA\Property(property="days_off", type="string", example="DaysOff", description="Barbers' days off")
 *          )
 *      )
 * )
 */

Flight::route('POST /api/barbers', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::barberService()->add($data));
});

/**
 * @OA\Put(
 *      path="/api/barbers/{id}",
 *      tags={"barbers"},
 *      summary="Update barbers data by id",
 *      @OA\Response(
 *           response=200,
 *           description="Updated barbers data, or 500 status code exception"
 *      ),
 *      @OA\Parameter(@OA\Schema(type="nubmer"), in="path", name="id", example="1", description="Barber id"),
 *      @OA\RequestBody(
 *          description="Barber data payload",
 *          @OA\JsonContent(
 *              required={"barber_name","barber_phoneNumber","barber_email", "barber_password", "work_start_time", "work_end_time", "days_off"},
 *              @OA\Property(property="barber_name", type="string", example="John Dao", description="Barbers' full name"),
 *              @OA\Property(property="barber_phoneNumber", type="string", example="+38761222333", description="Barbers' phone number"),
 *              @OA\Property(property="barber_email", type="string", example="johndoe@example.com", description="Barbers' email"),
 *              @OA\Property(property="barber_password", type="string", example="Password", description="Barbers' password"),
 *              @OA\Property(property="work_start_time", type="string", example="08:00:00", description="Barbers' shift start"),
 *              @OA\Property(property="work_end_time", type="string", example="16:00:00", description="Barbers' end of shift"),
 *              @OA\Property(property="days_off", type="string", example="DaysOff", description="Barbers' days off")
 *          )
 *      )
 * )
 */

Flight::route('PUT /api/barbers/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::barberService()->update($id, $data);
    Flight::json(Flight::barberService()->getById($id));
});

/**
 * @OA\Delete(
 *      path="/api/barbers/{id}",
 *      tags={"barbers"},
 *      summary="Delete barber by id",
 *      security = {
 *          {"ApiKey": {}}
 *      },
 *      @OA\Parameter(@OA\Schema(type="nubmer"), in="path", name="id", example="1", description="Barber id"),
 *      @OA\Response(
 *           response=200,
 *           description="Deleted barber data or 500 status code exception otherwise"
 *      ),
 * )
 */

Flight::route('DELETE /api/barbers/@id', function ($id) {
    Flight::barberService()->delete($id);
});
