<?php

namespace IFaqih\IFEncryption;

require_once __DIR__ . "/../component/Void.php";

use IFaqih\IFEncryption\Component\IFPassword;
use IFaqih\IFEncryption\Component\IFText;

class Encryption
{
    public static function password(string|int|null $algo = null, array $options = []): object
    {
        return new IFPassword([
            'use'       =>  $algo,
            'options'   =>  $options
        ]);
    }

    public static function text(array $config = [])
    {
        return new IFText($config);
    }
}
