<?php

namespace IFaqih\IFEncryption\Component\Password;

use Exception;
use IFaqih\IFEncryption\Component\AbstractPassword;
use IFaqih\IFEncryption\Component\Password\Encrypt;

class Main extends AbstractPassword
{
    private static $instance;

    public function __construct()
    {
        parent::__construct();
    }

    private static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    /**
     * Which set of algorithms will be used, which will be randomly selected by the library.
     *
     * @param array $algo The algorithms and options.
     * @return \IFaqih\IFEncryption\Component\Password\Main
     * @method set_default_options(): object
     * @method encrypt(string $str): string|false
     */
    public static function set_rand_algo(array $algo): object
    {
        try {
            if (!isset($algo[array_key_first($algo)]['algo']) && !isset($algo['algo'])) {
                $algo = array_filter($algo, fn ($value) => in_array($value, static::password_algo));
                $algo = array_values($algo);
                $algo = array_map(fn ($value) => ["algo" => $value], $algo);
            } else {
                $algo = isset($algo['algo']) ? [$algo] : $algo;
                $algo = array_filter($algo, fn ($value) => in_array($value['algo'], static::password_algo));
            }
            $count = count($algo);
            $algo = $count > 0 ? array_values($algo)[mt_rand(0, ($count - 1))] : throw new Exception("hash algorithm not found!");
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        if (isset($algo['options'])) {
            self::set_algo($algo['algo'])->set_options($algo['options']);
        } else {
            self::set_algo($algo['algo']);
        }

        return self::getInstance();
    }

    /**
     * Set of algorithms to be used.
     *
     * @param string $algo Algorithm to be used.
     * @return \IFaqih\IFEncryption\Component\Password\Method\AbstractMethod|\IFaqih\IFEncryption\Component\Password\Method\A17|\IFaqih\IFEncryption\Component\Password\Method\A33A71|\IFaqih\IFEncryption\Component\Password\Main
     * @throws \Exception
     * @method \IFaqih\IFEncryption\Component\Password\Method\AbstractMethod set_options(array $options): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A17 cost(int $cost): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A33A71 time_cost(int $time_cost): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A33A71 memory_cost(int $memory_cost): object
     * @method \IFaqih\IFEncryption\Component\Password\Method\A33A71 threads(int $threads): object
     * @method \IFaqih\IFEncryption\Component\Password\Main set_default_options(): object
     * @method \IFaqih\IFEncryption\Component\Password\Main encrypt(string $str): string|false
     */
    public static function set_algo(string $algo): object
    {
        try {
            $obj = match ($algo) {
                PASSWORD_BCRYPT                         =>  new \IFaqih\IFEncryption\Component\Password\Method\A17(),
                PASSWORD_ARGON2I, PASSWORD_ARGON2ID     =>  new \IFaqih\IFEncryption\Component\Password\Method\A33A71($algo),
                default                                 =>  throw new Exception("hash algorithm not found!")
            };
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        static::$options = $obj::___get_algo();
        return $obj;
    }

    /**
     * Set to the default options set by php.
     *
     * @return \IFaqih\IFEncryption\Component\Password\Main
     * @method encrypt(string $str): string|false
     */
    public static function set_default_options(): object
    {
        if (empty(static::$options)) {
            self::getInstance();
            self::set_rand_algo(static::$config);
        }
        static::$options['options'] = [];
        return self::getInstance();
    }

    /**
     * Execute the encryption command according to the algorithm and options that have been set.
     *
     * @param string $str String to be encrypted.
     * @return string|false Encrypted result string or false.
     */
    public static function encrypt(string $str): string|false
    {
        if (empty(static::$options)) {
            self::getInstance();
            self::set_rand_algo(static::$config);
        } else {
            if (isset(static::$options['algo']) && !isset(static::$options['options'])) {
                try {
                    if (empty(static::$options['algo'])) {
                        throw new Exception("algorithm not set!");
                    }

                    $config = array_search(static::$options['algo'], array_column(static::$config, 'algo'));
                    if ($config !== false) {
                        $config = static::$config[$config];
                        self::set_algo($config['algo'])->set_options($config['options']);
                    } else {
                        throw new Exception("options not set!");
                    }
                } catch (Exception $e) {
                    die("Error: " . $e->getMessage());
                }
            }
        }

        $obj = new Encrypt();
        $hash =  $obj->_encrypt($str);
        static::$options = NULL;

        return $hash;
    }

    /**
     * Verify string with existing hash.
     *
     * @param string $str String to verify.
     * @param string $existingHash Existing hashes.
     * @param bool $rehash Condition for automatic rehash or not.
     * @return bool Verification results.
     */
    public static function verify(string $str, string $existingHash, bool $rehash = TRUE): bool
    {
        require_once __DIR__ . "/Verify.php";
        $obj = new \IFaqih\IFEncryption\Component\Password\Verify();
        $verify =  $obj->_verify($str, $existingHash);

        if ($rehash) {
            $obj = new Encrypt();
            static::$new_hash = $obj->_encrypt($str);

            if (!$verify) {
                static::$new_hash = NULL;
            }
        }

        unset(static::$options['existing_hash']);

        return $verify;
    }

    /**
     * Get the new hash.
     *
     * @return string|null New hashes.
     */
    public static function new_hash(): string|null
    {
        return static::$new_hash;
    }

    /**
     * Get details of encryption.
     *
     * @return object Encryption details.
     */
    public static function get_details(): object
    {
        return json_decode(json_encode([
            "library_name"  => "IFEncryption",
            "version"       => static::version . "." . static::minor
        ] + static::$options));
    }

    /**
     * Get the algorithm data used.
     *
     * @return object Algorithm data.
     */
    public static function get_algo(): object
    {
        return json_decode(json_encode([
            'algo_name'     =>  static::$options['name'],
            'algo'          =>  static::$options['algo'],
            'alias'         =>  static::$options['algo_alias']
        ]));
    }

    /**
     * Get the data of the options used.
     *
     * @return object Options data.
     */
    public static function get_options(): object
    {
        return json_decode(json_encode(static::$options['options']));
    }
}
