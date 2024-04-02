<?php

$routes = [];

route('/', 'pages/pacientes.php');
route('/solicitar', 'pages/solicitar.php');
route('/solicitacoes', 'pages/solicitacoes.php');
route('/404', 'pages/404.php');

function route(string $path, string $pagePath) {
    global $routes;
    $routes[$path] = $pagePath;
}

run();

function run() {
    global $routes;
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $found = false;
    foreach ($routes as $path => $pagePath) {
        if (preg_match("#^$path$#", $uri, $matches)) {
            $found = true;
            include($pagePath);
            break;
        }
    }
    if (!$found) {
        include('pages/404.php');
    }
}