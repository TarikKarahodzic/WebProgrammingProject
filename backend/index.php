<?php

require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// import and register all business logic files (services) to FlightPHP
require_once __DIR__ . '/rest/services/AppointmentService.class.php';
require_once __DIR__ . '/rest/services/AuthService.class.php';
require_once __DIR__ . '/rest/services/BarberService.class.php';
require_once __DIR__ . '/rest/services/ServiceService.class.php';
require_once __DIR__ . '/rest/services/UserService.class.php';


Flight::register('appointmentService', "AppointmentService");
Flight::register('authService', "AuthService");
Flight::register('barberService', "BarberService");
Flight::register('serviceService', "ServiceService");
Flight::register('userService', "UserService");

// import all routes
require_once __DIR__ . '/rest/routes/AppointmentRoute.php';
require_once __DIR__ . '/rest/routes/AuthRoute.php';
require_once __DIR__ . '/rest/routes/BarberRoute.php';
require_once __DIR__ . '/rest/routes/ServiceRoute.php';
require_once __DIR__ . '/rest/routes/UserRoute.php';

// it is still possible to add custom routes after the imports
Flight::route('GET /api/', function () {
    echo "Hello";
});

Flight::start();