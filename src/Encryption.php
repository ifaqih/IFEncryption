<?php

namespace IFaqih\Library;

require_once __DIR__ . "/../component/Void.php";

class Encryption
{
    public static function password(string|int|null $algo = null, array $options = []): object
    {
        return new \IFaqih\Component\IFPassword([
            'use'       =>  $algo,
            'options'   =>  $options
        ]);
    }

    public static function text(array $config = [])
    {
        return new \IFaqih\Component\IFText($config);
    }
}
