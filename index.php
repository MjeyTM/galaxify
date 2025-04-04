<?php
// Load essentials
require_once './models/initialize_db.php';
require_once './models/Post.php';
require_once './controllers/Controller.php';
require_once './controllers/HomeController.php';
require_once './controllers/AuthController.php';
require_once './controllers/PostController.php';
require_once './helpers/Config.php';
require_once './basepath.php';
require_once './Routes.php';
require_once './helpers/Auth.php';
require_once './helpers/TimeAgo.php';

// base path of project
$Path = new Path();
$basepath = $Path->basePath();

// Dispatch the request
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($url, $method);