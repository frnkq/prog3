<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'composer/vendor/autoload.php';
require 'clases/PDOSingleton.php';
require 'clases/UsuarioAPI.php';
require 'clases/Login.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$usuariosRoutes = REQUIRE __dir__.'/routes/UsuarioRoutes.php';
$usuariosRoutes($app);

$loginRoutes = REQUIRE __dir__.'/routes/LoginRoutes.php';
$loginRoutes($app);


$roleMiddleware = REQUIRE __dir__.'/middleware/RoleMiddleware.php';
//this middleware is under LoginRoutes getAll
//$app->add($roleMiddleware);


$app->run();
