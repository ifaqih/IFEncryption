<?php

namespace IFaqih\IFEncryption\Component\Password\Version;

use Exception;

class PasswordDoc extends AbstractVersion
{
    private const version = "1";
    private const minor = "1";
    private const cost_hash_method = "chacha20";
    private static $_this;

    public function __construct()
    {
        static::$_this = static::name . "-" . static::version . "." . static::minor;
    }

    public function decustoming_hash(string $existingHash): array
    {
        $existingHash = substr($existingHash, 6);
        $ex = explode("$", $existingHash);
        $algo = null;
        $existingHash = '';
        foreach ($ex as $key => $value) {
            switch ($key) {
                case 0:
                    try {
                        switch ($value) {
                            case 'a17':
                                $name = "BCRYPT";
                                $algo = PASSWORD_BCRYPT;
                                break;
                            case 'a33':
                                $name = "ARGON2I";
                                $algo = PASSWORD_ARGON2I;
                                break;
                            case 'a71':
                                $name = "ARGON2ID";
                                $algo = PASSWORD_ARGON2ID;
                                break;
                            default:
                                throw new Exception("hash algorithm not found!");
                                break;
                        }
                    } catch (Exception $e) {
                        die("Error: " . $e->getMessage());
                    }

                    break;
                case 1:
                    $existingHash = $existingHash;
                    break;
                case 2:
                    $value = ($algo === PASSWORD_BCRYPT) ? substr($value, 16) : $value;
                    $iv_length = strlen(base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length(static::cost_hash_method)))) - 2;
                    $iv = base64_decode(substr($value, 0, $iv_length) . "==");
                    $cost = substr($value, $iv_length);
                    for ($i = 0; $i < 3; $i++) {
                        $cost = ($i === 0) ? base64_decode($cost) : base64_decode(substr($cost, 0, (-1 * $i)) . str_repeat("=", $i));
                        $cost = openssl_decrypt($cost, static::cost_hash_method, base64_encode("$" . strtoupper($ex[0]) . "=@" . static::$_this . ";\$a=" . ($algo === PASSWORD_BCRYPT ? "bcrypt" : $algo)), 0, $iv);
                        if ((($algo === PASSWORD_ARGON2I || $algo === PASSWORD_ARGON2ID) && preg_match("/^\d+;\d+;\d+;\d+$/", $cost)) || ($algo === PASSWORD_BCRYPT && preg_match("/^(\d)+$/", $cost))) {
                            break;
                        }
                    }

                    if ($algo === PASSWORD_BCRYPT) {
                        $existingHash .= "$" . $algo . "$" . $cost;
                    } else {
                        $options = explode(";", $cost);
                        $cost = (count($options) === 4) ? vsprintf("v=%d\$m=%d,t=%d,p=%d", $options) : NULL;
                        $existingHash .= "$" . $algo . "$" . $cost;
                    }
                    break;
                default:
                    $existingHash .= (($algo === PASSWORD_BCRYPT) ? ($key === 3 ? "$" . substr($value, -10) : $value) : "$" . $value);
                    break;
            }
        }

        $options = ($algo === PASSWORD_BCRYPT) ? [
            "cost"  =>  preg_match("/^(\d)+$/", $cost) ? $cost : NULL
        ] : (count($options) === 4 ? [
            'time_cost'     =>  $options[2],
            'memory_cost'   =>  $options[1],
            'threads'       =>  $options[3]
        ] : NULL);

        return [
            "existing_hash" =>  $existingHash,
            "name"          =>  $name,
            "algo"          =>  $algo,
            "algo_alias"    =>  $ex[0],
            "options"       =>  $options
        ];
    }
}
