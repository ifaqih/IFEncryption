<?php

namespace IFaqih\IFEncryption\Component\Password;

use IFaqih\IFEncryption\Component\Password\Main;

class Encrypt extends Main
{
    private const password_cost_hash_method = "chacha20";
    private static $iv_length;

    public function __construct()
    {
        parent::__construct();
        static::$iv_length = openssl_cipher_iv_length(static::password_cost_hash_method);
    }

    protected static function _encrypt(string $str): string|false
    {
        $hash = password_hash($str, static::$options['algo'], static::$options['options']);
        return (strlen($hash) > 13) ? self::customing_hash($hash) : FALSE;
    }

    private static function customing_hash(string $hash): string
    {
        $ex = explode("$", $hash);
        $hash = '';
        $v = null;
        $_this = static::name . "-" . static::version . "." . static::minor;
        foreach ($ex as $key => $value) {
            switch ($key) {
                case 1:
                    $hash .= static::name . "-" . static::version;
                    break;
                case 2:
                    if (static::$options['algo'] === PASSWORD_BCRYPT) {
                        $iv = openssl_random_pseudo_bytes(static::$iv_length);
                        $encrypt = openssl_encrypt($value, static::password_cost_hash_method, base64_encode("\$A17=@" . $_this . ";\$a=bcrypt"), 0, $iv);
                        $encrypt = base64_encode($encrypt);
                        $encrypt = substr($encrypt, 0, -4) . str_replace("PQ", "", str_replace("=", "", substr($encrypt, -4)));
                        $hash .= "\$a17$" . static::minor . "$" . self::rand_string(16) . substr(base64_encode($iv), 0, -2) . $encrypt;
                    } else {
                        $v = preg_replace("/[^0-9]/", "", $value);
                    }
                    break;
                case 3:
                    if (static::$options['algo'] === PASSWORD_BCRYPT) {
                        $hash .= "$" . self::rand_string(12) . substr($value, 0, 10) . "$" . substr($value, 10);
                    } else {
                        $value = preg_replace("/[^0-9,]/", "", $value);
                        $value = $v . "," . $value;
                        $value = str_replace(",", ";", $value);
                        $iv = openssl_random_pseudo_bytes(static::$iv_length);
                        $encrypt = openssl_encrypt($value, static::password_cost_hash_method, base64_encode("\$A" . ((static::$options['algo'] === PASSWORD_ARGON2I) ? "33" : "71") . "=@" . $_this . ";\$a=" . static::$options['algo']), 0, $iv);
                        $encrypt = base64_encode($encrypt);
                        $encrypt = substr($encrypt, 0, -4) . str_replace("PQ", "", str_replace("=", "", substr($encrypt, -4)));
                        $hash .= "\$a" . ((static::$options['algo'] === PASSWORD_ARGON2I) ? "33" : "71") . "$" . static::minor . "$" . substr(base64_encode($iv), 0, -2) . $encrypt;
                    }
                    break;
                default:
                    $hash .= "$" . $value;
                    break;
            }
        }

        return $hash;
    }

    private static function rand_string(int $length): string
    {
        return substr(base64_encode(openssl_random_pseudo_bytes($length)), 0, $length);
    }
}
