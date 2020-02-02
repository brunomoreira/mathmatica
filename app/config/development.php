<?php

require "../vendor/autoload.php";

use Slim\App;
use Slim\Container;
use App\Classes\Database;

// Start Sessions if necessary
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    session_regenerate_id(true);
}

// Set default timezone
date_default_timezone_set("Europe/Lisbon");

$config = [
  "development" => [
    "displayErrorDetails" => true,
    "addContentLengthHeader" => false
  ],
  "production" => [
    "displayErrorDetails" => false,
    "addContentLengthHeader" => false
  ]
];

// Instantiate Slim with config
// Ensure "production" mode when releasing the project
$app = new App([
    "settings" => $config["development"],
]);

// Get Slim Container
$container = $app->getContainer();

// Add Controllers
$container["UserController"] = function ($container) {
    return new \App\Controllers\UserController($container);
};

$container["HomeController"] = function ($container) {
    return new \App\Controllers\HomeController($container);
};

$container["ErrorController"] = function ($container) {
    return new \App\Controllers\ErrorController($container);
};

$container["TestController"] = function ($container) {
    return new \App\Controllers\TestController($container);
};

// Connect to Database
$databaseConfig = [
    "driver" => "mysql",
    "host" => "127.0.0.1",
    "database" => "mathmatica",
    "username" => "root",
    "password" => "root",
    "charset" => "utf8",
    "collation" => "utf8_unicode_ci",
    "prefix" => ""
];

$db = new Database($databaseConfig);

// Start the Database
$db->start();

// Store the db instance in the container
$container['db'] = $db->getInstance();
