<?php
require_once __DIR__.'/../src/Bootstrap.php';

\App\Bootstrap::init(false);        // on boote sans lancer le dispatch

$router = new \App\Router();

/* ------------- Déclarations de routes ------------- */
$router->get('/',                     [\App\Controllers\HomeController::class,  'index']);
$router->get('/login',                [\App\Controllers\AuthController::class,  'showLogin']);
$router->post('/login',               [\App\Controllers\AuthController::class,  'login']);
$router->get('/logout',               [\App\Controllers\AuthController::class,  'logout']);

$router->get('/rides',                [\App\Controllers\RideController::class,  'index']);
$router->get('/rides/create',         [\App\Controllers\RideController::class,  'create']);
$router->post('/rides',               [\App\Controllers\RideController::class,  'store']);
$router->get('/ride/{id}',            [\App\Controllers\RideController::class,  'show']);
$router->post('/ride/{id}/cancel',    [\App\Controllers\RideController::class,  'cancel']);

$router->post('/ride/{id}/reviews',   [\App\Controllers\ReviewController::class,'store']);
$router->get('/ride/{id}/reviews',    [\App\Controllers\ReviewController::class,'list']);
/* -------------------------------------------------- */

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
