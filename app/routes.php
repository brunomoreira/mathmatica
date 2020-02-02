<?php

require "bootstrap.php";

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Test Route - GET
//$app->get("/test", "TestController:get");

// Home Route - GET
$app->get("/start", "HomeController:home");

// User Route Group
$app->group("/user", function() {

    // Session - GET
    $this->get("/session", "UserController:session");

    // Register - POST
    $this->post("/register", "UserController:register");

    // Activate - GET
    $this->get("/activate/{email}/{activationCode}", "UserController:activate");

    // Login - POST
    $this->post("/login", "UserController:login");

    // Logout - GET
    $this->get("/logout", "UserController:logout");

    // Recover Password - POST
    $this->post("/recover/password", "UserController:forgot_password");

    // Resend Activation - POST
    $this->post("/activation/resend", "UserController:resend_activation");

    // Contact - POST
    $this->post("/contact", "UserController:contact");

    // Edit Profile - POST
    $this->post("/profile/edit", "UserController:edit");

});

// Error Route Group
$app->group("/error", function() {

    // Activation Error
    $this->get("/activation", "ErrorController:activation");

});

// Test Route *** Remove on production ***
$app->get("/test", "TestController:test");

// Fallback Route - Redirect To Start Route if URI is not defined by any route
$app->any("/[{route}]", function (Request $req, Response $res, $args) {

    // *** Remove the /test path on production
    if($req->isGet() && $req->getURI()->getPath() != "/start" && $req->getURI()->getPath() != '/test') {
        return $res->withStatus(302)->withHeader("Location", "/start");
    }

});