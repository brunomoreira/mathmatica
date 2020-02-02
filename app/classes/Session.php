<?php

namespace App\Classes;

class Session
{
    // Set Session
    public static function set($key, $value) 
    {
        return $_SESSION[$key] = $value;
    }

    // Get Session
    public static function get($key)
    {
        try {
            return $_SESSION[$key];
        } catch(Exception $error) {
            return $error->getMessage();
        }
    }

    // Check Session
    public static function hasSession($key)
    {
        return isset($_SESSION[$key]);
    }

    // Delete Session
    public static function clear($key)
    {
        try {
            unset($_SESSION[$key]);
        } catch(Exception $error) {
            return $e->getMessage();
        }
    }

}