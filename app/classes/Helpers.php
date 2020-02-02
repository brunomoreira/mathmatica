<?php

namespace App\Classes;

class Helpers
{
    public static function sanitize($data)
	{
        if(is_array($data)) {
            foreach ($data as $index => $value) {
                $data[$index] = htmlentities(trim($value), ENT_QUOTES, "UTF-8");
            }
        }

        if(is_string($data)) {
            $data = htmlentities(trim($data), ENT_QUOTES, "UTF-8");
        }

        return $data;
    }

    public static function error($message = 'Oops! Ocorreu um erro.')
    {
        return $message;
    }

    public static function hash($string = '')
    {
        return password_hash($string, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public static function check($password, $hash)
    {
        return password_verify($password, $hash);
    }

    // As demonstrated in - https://stackoverflow.com/questions/15699101/get-the-client-ip-address-using-php
    public static function get_ip()
    {
        $ipaddress = '';

        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}