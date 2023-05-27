<?php

try {
    if (PHP_MAJOR_VERSION > 7) {
        define("DONT_REHASH", 1);
        define("REHASH_FIXED", 2);
        define("REHASH_CONFIG", 4);
        define("REHASH_BCRYPT", 8);
        define("REHASH_ARGON2I", 16);
        define("REHASH_ARGON2ID", 32);
        define("REHASH_RAND_ALL_ALGO", 64);
        define("REHASH_DEFAULT_OPTIONS", 128);

        require_once __DIR__ . "/AbstractPassword.php";
        require_once __DIR__ . "/password/version/AbstractVersion.php";
        require_once __DIR__ . "/password/Main.php";
        require_once __DIR__ . "/password/method/AbstractMethod.php";
        require_once __DIR__ . "/password/method/A17.php";
        require_once __DIR__ . "/password/method/A33A71.php";
        require_once __DIR__ . "/password/Encrypt.php";
    } else {
        throw new Exception("This library runs on php version 8.0 or above!");
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
