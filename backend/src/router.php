<?php
/*
 *
 * Router
 *
 */

$routesFile = file_get_contents(__DIR__ . "/../src/routes.json");
$routes     = json_decode($routesFile, true);

foreach($routes as $route) {
    if($route['type'] == 'GET') {
        $controller = "\\App\\Controller\\".$route['controller'];
        $app->get($route['name'], [$controller, $route['method']]);
    }

    if($route['type'] == 'POST') {
        $controller = "\\App\\Controller\\".$route['controller'];
        $app->post($route['name'], [$controller, $route['method']]);
    }
}
