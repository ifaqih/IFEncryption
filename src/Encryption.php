<?php

namespace IFaqih\IFEncryption;

require_once __DIR__ . "/../component/Void.php";

class Encryption
{
    public static function password(string|int|null $algo = null, array $options = []): object
    {
        return new \IFaqih\IFEncryption\Component\IFPassword([
            'use'       =>  $algo,
            'options'   =>  $options
        ]);
    }

    public static function text(array $config = [])
    {
        return new \IFaqih\IFEncryption\Component\IFText($config);
    }
}
