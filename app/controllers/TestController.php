<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;

use App\Classes\Helpers;
use App\Models\Module;

class TestController
{
  protected $container;

  public function __construct(Container $container)
  {
    $this->container = $container;
  }

  public function test(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    $password = Helpers::hash('lol123');

    return $res->withJson([
      'password' => $password,
      'isRight' => Helpers::check('lol123', $password),
      'modules' => Module::all(),
      'key' => bin2hex(openssl_random_pseudo_bytes(32))
    ]);
  }
}