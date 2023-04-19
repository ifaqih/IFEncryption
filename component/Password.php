<?php

namespace IFaqih\Component;

use IFaqih\Component\Main;
use Exception;

class IFPassword
{
    private const cost_hashing_method = "chacha20";
    private static $iv_length;
    private static $use;
    private static $algo;
    private static $option;

    public function __construct(array $con)
    {
        $con = (empty($con['use'])) ? Main::get_config('password') : $con;

        if ($con['use'] === PASSWORD_BCRYPT && CRYPT_BLOWFISH !== 1) {
            throw new Exception("bcrypt not supported in this installation. See http://php.net/crypt");
        } else {
            static::$use = $con['use'];
            static::$option = $con['options'];
            switch (static::$use) {
                case PASSWORD_BCRYPT:
                    static::$algo = "if-0";
                    static::$iv_length = openssl_cipher_iv_length(static::cost_hashing_method);
                    break;
                case PASSWORD_ARGON2I:
                    static::$algo = "if-1";
                    break;
                case PASSWORD_ARGON2ID:
                    static::$algo = "if-2";
                    break;
                default:
                    throw new Exception("hash algorithm not found!");
                    break;
            }
        }
    }

    public function encrypt(string $input): string|false
    {
        $input = hash("sha3-512", $input);
        $hash = password_hash($input, static::$use, static::$option);

        if (strlen($hash) > 13) {
            $ex = explode("$", $hash);
            $hash = '';
            foreach ($ex as $key => $value) {
                if (static::$algo === "if-0" && $key === 2) {
                    $iv = openssl_random_pseudo_bytes(static::$iv_length);
                    $encrypt = openssl_encrypt($value, static::cost_hashing_method, static::$option['salt_cost'], 0, $iv);
                    $hash .= "\$v=19\$m=1024,t=1300,p=2$" . substr($encrypt, 0, -1) . substr(base64_encode($iv), 0, -2);
                } else if ($key === 1) {
                    $hash .= static::$algo;
                } else {
                    $hash .= "$" . $value;
                }
            }
            return $hash;
        } else {
            return FALSE;
        }
    }

    public function valid(string $input, string $existingHash, string|null $salt_cost = null): bool
    {
        $input = hash("sha3-512", $input);

        $ex = explode("$", $existingHash);
        $existingHash = '';
        foreach ($ex as $key => $value) {
            if ($key === 1) {
                switch ($value) {
                    case 'if-0':
                        $existingHash .= "2y";
                        static::$algo = PASSWORD_BCRYPT;
                        break;
                    case 'if-1':
                        $existingHash .= "argon2i";
                        static::$algo = PASSWORD_ARGON2I;
                        break;
                    case 'if-2':
                        $existingHash .= "argon2id";
                        static::$algo = PASSWORD_ARGON2ID;
                        break;
                    default:
                        throw new Exception("hash algorithm not found!");
                        break;
                }
            } else if ($key === 4 && static::$algo === PASSWORD_BCRYPT && !empty($salt_cost)) {
                static::$iv_length = openssl_cipher_iv_length(static::cost_hashing_method);
                $iv = openssl_random_pseudo_bytes(static::$iv_length);
                $iv_length = strlen(base64_encode($iv)) - 2;
                $iv = substr($value, -$iv_length);
                $cost = str_replace($iv, "", $value);
                $cost = openssl_decrypt($cost . "=", static::cost_hashing_method, $salt_cost, 0, base64_decode($iv . "=="));
                $existingHash .= "$" . $cost;
            } else {
                $existingHash .= ($key === 3 && static::$algo === PASSWORD_BCRYPT && !empty($salt_cost)) ? "" : (($key === 2 && static::$algo === PASSWORD_BCRYPT && !empty($salt_cost)) ? "" : "$" . $value);
            }
        }
        return password_verify($input, $existingHash);
    }
}
