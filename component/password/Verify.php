<?php

namespace IFaqih\IFEncryption\Component\Password;


use Exception;
use IFaqih\IFEncryption\Component\Password\Main;

class Verify extends Main
{
    protected function _verify(string $str, string $existingHash): bool
    {
        $this->doc_validation($existingHash);

        $verify =  password_verify($str, static::$options['existing_hash']);

        return $verify;
    }

    private function doc_validation(string $existingHash): void
    {
        $ex = explode("$", $existingHash);
        $version = str_replace("if-", "", $ex[1]);
        $minor = $ex[3];
        unset($ex);
        if (file_exists(__DIR__ . "/version/v" . $version . "." . $minor . ".php")) {
            require_once __DIR__ . "/version/v" . $version . "." . $minor . ".php";
            $class = new \IFaqih\IFEncryption\Component\Password\Version\PasswordDoc();
            $decustom = $class->decustoming_hash($existingHash);
        } else {
            throw new Exception("file" . __DIR__ . "/version/v" . $version . "." . $minor . ".php not found!");
            die();
        }

        static::$options = $decustom;
    }
}
