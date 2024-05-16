<?php
require("/wamp64/www/WebProgrammingProject/vendor/autoload.php");
$openapi = \OpenApi\Generator::scan(['/wamp64/www/WebProgrammingProject/api/']);
header('Content-Type: application/json');
echo $openapi->toJson();