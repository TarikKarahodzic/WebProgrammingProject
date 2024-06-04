<?php

require __DIR__ . '/../../vendor/autoload.php';

/**
 * @OA\Get(
 *      path="/api/services",
 *      tags={"services"},
 *      summary="Get all services",
 *      security={
 *          {"ApiKey": {}}   
 *      },
 *      @OA\Response(
 *           response=200,
 *           description="services list"
 *      )
 * )
 */

 Flight::route('GET /api/services', function () {
    Flight::json(Flight::serviceService()->get_all());
});

/**
 * @OA\Get(
 *      path="/api/services/{id}",
 *      tags={"services"},
 *      summary="Get service by id",
 *      security = {
 *          {"ApiKey": {}}
 *      },
 *      @OA\Response(
 *           response=200,
 *           description="Service data, false if the service does not exist"
 *      ),
 *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Service ID")
 * )
 */

Flight::route('GET /api/services/@id', function ($id) {
    Flight::json(Flight::serviceService()->getById($id));
});

/**
 * @OA\Post(
 *      path="/api/services",
 *      tags={"services"},
 *      summary="Add services data to the database",
 *      security = {
 *          {"ApiKey": {}}
 *      },
 *      @OA\Response(
 *           response=200,
 *           description="Services data, or exception if services is not added properly"
 *      ),
 *      @OA\RequestBody(
 *          description="Service data payload",
 *          @OA\JsonContent(
 *              required={"service-type","service_description","service_price"},
 *              @OA\Property(property="service-type", type="string", example="Short hair cut", description="service type"),
 *              @OA\Property(property="service_description", type="string", example="Short hair cut", description="service description"),
 *              @OA\Property(property="service_price", type="string", example="20.00 KM", description="service price")
 *          )
 *      )
 * )
 */

Flight::route('POST /api/services', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::serviceService()->add($data));
});

/**
 * @OA\Put(
 *      path="/api/services/{id}",
 *      tags={"services"},
 *      summary="Update services data by id",
 *      security = {
 *          {"ApiKey": {}}
 *      },
 *      @OA\Response(
 *           response=200,
 *           description="Updated services data, or 500 status code exception"
 *      ),
 *      @OA\Parameter(@OA\Schema(type="nubmer"), in="path", name="id", example="1", description="Service id"),
 *      @OA\RequestBody(
 *          description="Service data payload",
 *          @OA\JsonContent(
 *              required={"service-type","service_description","service_price"},
 *              @OA\Property(property="service-type", type="string", example="Short hair cut", description="service type"),
 *              @OA\Property(property="service_description", type="string", example="Short hair cut", description="service description"),
 *              @OA\Property(property="service_price", type="string", example="20.00 KM", description="service price")
 *          )
 *      )
 * )
 */

Flight::route('PUT /api/services/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::serviceService()->update($id, $data);
    Flight::json(Flight::serviceService()->getById($id));
});

/**
 * @OA\Delete(
 *      path="/api/services/{id}",
 *      tags={"services"},
 *      summary="Delete service by id",
 *      @OA\Parameter(@OA\Schema(type="nubmer"), in="path", name="id", example="1", description="Service id"),
 *      @OA\Response(
 *           response=200,
 *           description="Deleted service data or 500 status code exception otherwise"
 *      ),
 * )
 */

Flight::route('DELETE /api/services/@id', function ($id) {
    Flight::serviceService()->delete($id);
});
 