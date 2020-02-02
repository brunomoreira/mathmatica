<?php

namespace App\Classes;

use Illuminate\Database\Capsule\Manager;

class Database
{
  private $db;

  public function __construct($mode)
  {
    $this->db = new Manager();

    $this->db->addConnection($mode);

    $this->db->setAsGlobal();

  }

  public function getInstance()
  {
    return $this->db;
  }

  public function start()
  {
    return $this->db->bootEloquent();
  }
}