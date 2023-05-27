<?php

namespace IFaqih\IFEncryption\Component;

use Exception;

abstract class AbstractPassword
{
    protected const name = "if";
    protected const version = "1";
    protected const minor = "1";
    protected const build = "0";

    protected const password_algo = [
        PASSWORD_BCRYPT,
        PASSWORD_ARGON2I,
        PASSWORD_ARGON2ID
    ];

    protected static $config;

    protected static $options;
    protected static $new_hash;

    public function __construct()
    {
        static::$config = require file_exists(__DIR__ . "/../../../../config/if-encryption.php") ? __DIR__ . "/../../../../config/if-encryption.php" : (file_exists(__DIR__ . "/../config/if-encryption.php") ? __DIR__ . "/../config/if-encryption.php" : throw new Exception("config/if-encryption.php not found!"));
    }

    abstract public static function hash(string $str);
}
