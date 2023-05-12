<?php

try {
    if (PHP_MAJOR_VERSION > 7) {
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
