<?php

namespace IFaqih\IFEncryption\Component;

use Exception;

class Main
{
    public static function get_config(string $type): array
    {
        $config = require file_exists(__DIR__ . "/../../config/if-encryption.php") ? __DIR__ . "/../../config/if-encryption.php" : (file_exists(__DIR__ . "/../config/if-encryption.php") ? __DIR__ . "/../config/if-encryption.php" : throw new Exception("config/if-encryption.php not found!"));

        return $config[$type];
    }
}
