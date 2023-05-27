<?php

namespace IFaqih\IFEncryption\Component\Password\Method;

use Exception;
use IFaqih\IFEncryption\Component\Password\Method\AbstractMethod;

class A33A71 extends AbstractMethod
{
    private static $selected_algo;

    public function __construct(string $algo)
    {
        parent::__construct();
        static::$selected_algo = static::algo[$algo];
    }

    public function set_options(array $options): object
    {
        try {
            if (!isset($options['time_cost'])) {
                throw new Exception("time_cost in set_config() array parameter is not set!");
            }
            if (!isset($options['memory_cost'])) {
                throw new Exception("memory_cost in set_config() array parameter is not set!");
            }
            if (!isset($options['threads'])) {
                throw new Exception("threads in set_config() array parameter is not set!");
            }
            if (!preg_match("/^(\d)+$/", $options['time_cost'])) {
                throw new Exception("the time_cost value in the set_config() array parameter must be an integer!");
            }
            if (!preg_match("/^(\d)+$/", $options['memory_cost'])) {
                throw new Exception("the memory_cost value in the set_config() array parameter must be an integer!");
            }
            if (!preg_match("/^(\d)+$/", $options['threads'])) {
                throw new Exception("the threads value in the set_config() array parameter must be an integer!");
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        static::$options['options'] = $options;

        return self::getInstance();
    }

    /**
     * Set time cost of algorithms to be used.
     *
     * @param string $algo Algorithm to be used.
     * @return \IFaqih\IFEncryption\Component\Password\Method\A33A71|\IFaqih\IFEncryption\Component\Password\Method\AbstractMetho|\IFaqih\IFEncryption\Component\Password\Main
     * @throws \Exception
     * @method \IFaqih\IFEncryption\Component\Password\Method\AbstractMethod set_options(array $options): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A33A71 memory_cost(int $memory_cost): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A33A71 threads(int $threads): object
     * @method \IFaqih\IFEncryption\Component\Password\Main hash(string $str): string|false
     */
    public function time_cost(int $time_cost): object
    {
        try {
            if (!preg_match("/^(\d)+$/", $time_cost)) {
                throw new Exception("the time_cost value in the time_cost() parameter must be an integer!");
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        static::$options['options']['time_cost'] = $time_cost;

        return $this;
    }

    /**
     * Set memory cost of algorithms to be used.
     *
     * @param string $algo Algorithm to be used.
     * @return \IFaqih\IFEncryption\Component\Password\Method\A33A71|\IFaqih\IFEncryption\Component\Password\Method\AbstractMetho|\IFaqih\IFEncryption\Component\Password\Main
     * @throws \Exception
     * @method \IFaqih\IFEncryption\Component\Password\Method\AbstractMethod set_options(array $options): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A17 cost(int $cost): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A33A71 time_cost(int $time_cost): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A33A71 threads(int $threads): object
     * @method \IFaqih\IFEncryption\Component\Password\Main hash(string $str): string|false
     */
    public function memory_cost(int $memory_cost): object
    {
        try {
            if (!preg_match("/^(\d)+$/", $memory_cost)) {
                throw new Exception("the memory_cost value in the memory_cost() parameter must be an integer!");
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        static::$options['options']['memory_cost'] = $memory_cost;

        return $this;
    }

    /**
     * Set threads of algorithms to be used.
     *
     * @param string $algo Algorithm to be used.
     * @return \IFaqih\IFEncryption\Component\Password\Method\A33A71|\IFaqih\IFEncryption\Component\Password\Method\AbstractMetho|\IFaqih\IFEncryption\Component\Password\Main
     * @throws \Exception
     * @method \IFaqih\IFEncryption\Component\Password\Method\AbstractMethod set_options(array $options): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A17 cost(int $cost): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A33A71 time_cost(int $time_cost): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A33A71 memory_cost(int $memory_cost): object
     * @method \IFaqih\IFEncryption\Component\Password\Main hash(string $str): string|false
     */
    public function threads(int $threads): object
    {
        try {
            if (!preg_match("/^(\d)+$/", $threads)) {
                throw new Exception("the threads value in the threads() parameter must be an integer!");
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        static::$options['options']['threads'] = $threads;

        return $this;
    }

    protected static function ___get_algo(): array
    {
        return static::$selected_algo;
    }
}
