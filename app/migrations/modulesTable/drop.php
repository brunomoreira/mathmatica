<?php

require "vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use App\Classes\Database;

$db = new Database([
  "driver" => "mysql",
  "host" => "127.0.0.1",
  "database" => "mathmatica",
  "username" => "root",
  "password" => "root",
  "charset" => "utf8",
  "collation" => "utf8_unicode_ci",
  "prefix" => ""
]);

$db->start();

//Creating schema
Capsule::schema()->dropIfExists("modules");