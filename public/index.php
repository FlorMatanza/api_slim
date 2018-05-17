<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;
$app->get('/', function (Request $request, Response $response, array $args) {

    $response->getBody()->write("<h1>Página de gestión API REST de la aplicación de Flor</h1>");

    return $response;
});

// Crear las rutas para el empleado
require "../src/rutas/empleados.php";

$app->run();
?>

