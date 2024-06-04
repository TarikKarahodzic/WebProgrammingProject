<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * @OA\Post(
 *      path="/auth/login",
 *      tags={"auth"},
 *      summary="Login to system using email and password",
 *      @OA\Response(
 *           response=200,
 *           description="User data and JWT"
 *      ),
 *      @OA\RequestBody(
 *          description="Credentials",
 *          @OA\JsonContent(
 *              required={"user_email","user_password"},
 *              @OA\Property(property="user_email", type="string", example="email@example.com", description="User email"),
 *              @OA\Property(property="user_password", type="string", example="password", description="User password"),
 *          )
 *      )
 * )
 */

Flight::route('POST /auth/login', function () {
    $payload = Flight::request()->data->getData();
    $user = Flight::authService()->get_user_by_email($payload['user_email']);

    if (!$user || !password_verify($payload['user_password'], $user['user_password'])) {
        Flight::json(['error' => true, 'message' => 'Invalid password or email!'], 401);
        return;
    }

    $jwt = generate_jwt($user);
    Flight::json(['error' => false, 'data' => $user + ['token' => $jwt]]);
});

function generate_jwt($user)
{
    $secret_key = JWT_SECRET;
    $issuer = "http://localhost";
    $audience = "http://localhost";
    $issued_at = time();
    $expiration_time = $issued_at + (60 * 60);

    $payload = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "data" => array(
            "id" => $user['id'],
            "name" => $user['user_name'],
            "email" => $user['user_email'],
            "phoneNumber" => $user['user_phoneNumber'],
            "userpassword" => $user['user_password']
        )
    );

    $jwt = JWT::encode($payload, $secret_key, 'HS256');
    return $jwt;
}

/**
 * @OA\Post(
 *      path="/auth/logout",
 *      tags={"auth"},
 *      summary="Logout out of system",
 *      @OA\Response(
 *           response=200,
 *           description="User data and JWT"
 *      ),
 * )
 */
Flight::route('POST /auth/logout', function () {
    try {
        $token = Flight::request()->getHeader("Authentication");
        if (!$token)
            Flight::json(['error' => true, 'message' => 'Missing authentication header!']);

        $decoded_token = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));

        Flight::json([
            'jwt_decoded' => $decoded_token,
            'user' => $decoded_token->data
        ]);
    } catch (\Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});
