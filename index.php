<?php

$routes = [];

route('/', 'pages/pacientes.php');
route('/form_solicitacao', 'pages/form_solicitacao.php');
route('/solicitacoes', 'pages/solicitacoes.php');
route('/404', 'pages/404.php');

function route(string $path, string $pagePath) {
    global $routes;
    $routes[$path] = $pagePath;
}

run();

function run() {
    global $routes;
    $uri = $_SERVER['REQUEST_URI'];
    $found = false;
    foreach ($routes as $path => $pagePath) {
        if ($path !== $uri) continue;
        $found = true;
        include($pagePath);
        break;
    }

    if (!$found) {
        include('pages/404.php');
    }
}