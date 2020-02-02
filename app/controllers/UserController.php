<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use App\Models\User;
use App\Classes\Session;

class UserController
{
  protected $container;

  public function __construct(Container $container)
  {
    $this->container = $container;
  }

  public function register(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    $user = new User;
    
    return $res->withJson($user->register($req->getParsedBody()));
  }

  public function activate(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    $email = $req->getAttribute('email');
    $activationCode = $req->getAttribute('activationCode');

    if(User::activate($email, $activationCode)) {
      return $res->withStatus(302)->withHeader("Location", "/start");
    }

    return $res->withStatus(302)->withHeader("Location", "/error/activation");
  }

  public function login(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    $user = new User;
    
    return $res->withJson($user->login($req->getParsedBody()));
  }

  public function logout(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    Session::clear('user');

    return $res->withJson([
      'hasLoggedOut' => true
    ]);
  }

  public function session(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    if(Session::hasSession('user')) {
      return $res->withJson([
        'hasSession' => true,
        'session' => Session::get('user')
      ]);
    } else {
      return $res->withJson([
        'hasSession' => false
      ]);
    }
  }

  public function forgot_password(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    $user = new User;

    return $res->withJson($user->recover_password($req->getParsedBody()));
  }

  public function resend_activation(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    $user = new User;

    return $res->withJson($user->resend_activation($req->getParsedBody()));
  }

  public function contact(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    $user = new User;

    return $res->withJson($user->contact($req->getParsedBody(), $this->container));
  }

  public function edit(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    $user = new User;

    return $res->withJson($user->edit($req->getParsedBody()));
  }

}