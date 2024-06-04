<?php

// Set the reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

// Database access 
define('DB_NAME', 'localbarber');
define('DB_PORT', 3308);
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', '127.0.0.1');

define('JWT_SECRET', '*AMk._3kjV3tvm&UtkeX[&d?Q4.Qn;');
