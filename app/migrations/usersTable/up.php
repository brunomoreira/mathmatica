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
Capsule::schema()->create("users", function (Blueprint $table) {
    $table->increments("id");
    $table->string("email")->unique();
    $table->string("username");
    $table->string("password");
    $table->boolean("premium")->default(false);
    $table->boolean("active")->default(false);
    $table->string("activationCode")->nullable()->default(NULL);
    $table->integer("avatar_id")->default(1);
    $table->timestamp("last_forgot_password_attempt")->nullable()->default(NULL);
    $table->timestamp("last_resend_activation_attempt")->nullable()->default(NULL);
    $table->timestamps();
});