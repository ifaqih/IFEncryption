<?php

namespace IFaqih\IFEncryption\Component\Password\Method;

use Exception;
use IFaqih\IFEncryption\Component\Password\Method\AbstractMethod;

class A17 extends AbstractMethod
{
    public function __construct()
    {
        parent::__construct();
    }

    public function set_options(array $options): object
    {
        if (is_array($options)) {
            try {
                if (isset($options['cost'])) {
                    $options = $options['cost'];
                } else {
                    throw new Exception("cost in set_config() is not set!");
                }

                if (!preg_match("/^(\d)+$/", $options)) {
                    throw new Exception("cost must be an integer value!");
                }
            } catch (Exception $e) {
                die("Error: " . $e->getMessage());
            }
        }
        static::$options['options'] = ["cost" => $options];

        return $this;
    }

    /**
     * Set cost of bcrypt to be used.
     *
     * @param string $algo Algorithm to be used.
     * @return \IFaqih\IFEncryption\Component\Password\Main
     * @throws \Exception
     * @method \IFaqih\IFEncryption\Component\Password\Main encrypt(string $str): string|false
     */
    public function cost(int $cost): object
    {
        try {
            if (!preg_match("/^(\d)+$/", $cost)) {
                throw new Exception("cost must be an integer value!");
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        static::$options['options'] = ["cost" => $cost];

        return $this;
    }

    protected static function ___get_algo(): array
    {
        return static::algo[PASSWORD_BCRYPT];
    }
}
