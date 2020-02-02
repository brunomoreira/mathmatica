<?php

require "../app/bootstrap.php";
require "../app/routes.php";

// TWIG
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('./dist/templates', [
        'cache' => false
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

// 500 Error
// $container = $app->getContainer();

// $container['phpErrorHandler'] = function ($container) {
//     return function ($request, $response, $error) use ($container) {
//         return $container['response']->withStatus(500)->withJson([
//             'error' => 500
//         ]);
//     };
// };

// 404 Error
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $response->withStatus(302)->withHeader("Location", "/start");
    };
};


// 405 Error
$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $response->withStatus(302)->withHeader("Location", "/start");
    };
};


$app->run();