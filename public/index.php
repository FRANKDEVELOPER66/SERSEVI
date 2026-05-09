<?php
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\ReciboPDFController;
use Controllers\RecibosController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class, 'index']);

// ── Recibos ────────────────────────────────────────────────────────
$router->get('/recibos',                  [RecibosController::class, 'index']);
$router->get('/recibos/nuevo',            [RecibosController::class, 'nuevo']);
$router->post('/recibos/crear',           [RecibosController::class, 'crear']);
$router->get('/recibos/ver',              [RecibosController::class, 'ver']);
$router->post('/recibos/anular',          [RecibosController::class, 'anular']);
$router->get('/recibos/siguiente-numero', [RecibosController::class, 'siguienteNumero']);



$router->get('/recibos/pdf', [ReciboPDFController::class, 'generar']);

$router->comprobarRutas();
