<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;

class HomeController
{
  protected $container;

  public function __construct(Container $container)
  {
    $this->container = $container;
  }

  public function home(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    return $this->container->view->render($res, 'index.html.twig');
  }
}