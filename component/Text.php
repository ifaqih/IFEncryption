<?php

namespace IFaqih\Component;

use IFaqih\Component\Main;

class IFText
{
    protected static $chiper;
    protected static $key;
    protected static $option;

    public function __construct($con)
    {
        $con = (!isset($con['cipher']) || !isset($con['key']) || !isset($con['option'])) ? Main::get_config('text') : $con;

        static::$chiper = $con['cipher'];
        static::$key = $con['key'];
        static::$option = $con['option'];
    }

    public function encrypt(string $input): object|false
    {
        $iv = openssl_cipher_iv_length(static::$chiper);
        $iv = openssl_random_pseudo_bytes($iv);
        $return = openssl_encrypt($input, static::$chiper, static::$key, static::$option, $iv);
        return ($return !== FALSE) ? (object) ["return" => $return, "iv" => $iv] : FALSE;
    }

    public function decrypt(string $input, string $iv): string|false
    {
        return openssl_decrypt($input, static::$chiper, static::$key, static::$option, $iv);
    }
}
