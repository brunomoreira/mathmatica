<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;

class ErrorController
{
  protected $container;

  public function __construct(Container $container)
  {
    $this->container = $container;
  }

  public function activation(ServerRequestInterface $req, ResponseInterface $res, $args)
  {
    return $this->container->view->render($res, 'error.html.twig', [
      'error' => 'Activação Falhou!'
    ]);
  }

}