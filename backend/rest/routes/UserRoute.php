<?php

require __DIR__ . '/../../vendor/autoload.php';

/**
 * @OA\Get(
 *      path="/api/users",
 *      tags={"users"},
 *      summary="Get all users",
 *      @OA\Response(
 *           response=200,
 *           description="users list"
 *      )
 * )
 */

Flight::route('GET /api/users', function () {
    Flight::json(Flight::userService()->get_all());
});

/**
 * @OA\Get(
 *      path="/api/users/{id}",
 *      tags={"users"},
 *      summary="Get user by id",
 *      @OA\Response(
 *           response=200,
 *           description="User data, false if the users does not exist"
 *      ),
 *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="Users ID")
 * )
 */

Flight::route('GET /api/users/@id', function ($id) {
    Flight::json(Flight::userService()->getById($id));
});

/**
 * @OA\Post(
 *      path="/api/users",
 *      tags={"users"},
 *      summary="Add users data to the database",
 *      @OA\Response(
 *           response=200,
 *           description="users data, or exception if users is not added properly"
 *      ),
 *      @OA\RequestBody(
 *          description="user data payload",
 *          @OA\JsonContent(
 *              required={"user_name","user_phoneNumber","user_email", "user_password"},
 *              @OA\Property(property="user_name", type="string", example="John Dao", description="users' full name"),
 *              @OA\Property(property="user_email", type="string", example="johndoe@example.com", description="users' email"),
 *              @OA\Property(property="user_phoneNumber", type="string", example="+38761222333", description="users' phone number"),
 *              @OA\Property(property="user_password", type="string", example="Password", description="users' password"),
 *          )
 *      )
 * )
 */

 Flight::route('POST /api/users', function () {
    $data = Flight::request()->data->getData();
    $data['user_password'] = password_hash($data['user_password'], PASSWORD_DEFAULT);
    Flight::json(Flight::userService()->add($data));
});

/**
 * @OA\Delete(
 *      path="/api/users/{id}",
 *      tags={"users"},
 *      summary="Delete users by id",
 *      @OA\Parameter(@OA\Schema(type="nubmer"), in="path", name="id", example="1", description="Users id"),
 *      @OA\Response(
 *           response=200,
 *           description="Deleted users data or 500 status code exception otherwise"
 *      ),
 * )
 */

Flight::route('DELETE /api/users/@id', function ($id) {
    Flight::userService()->delete($id);
});

