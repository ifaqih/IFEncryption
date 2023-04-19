<?php

if (PHP_MAJOR_VERSION < 8) {
    throw new Exception("This library runs on php version 8.0 or above!");
    exit;
}

require_once __DIR__ . "/Main.php";
require_once __DIR__ . "/Password.php";
require_once __DIR__ . "/Text.php";
