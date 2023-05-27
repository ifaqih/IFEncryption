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

    protected static function getInstance()
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
     * @method hash(string $str): string|false
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
            $algo = $count > 0 ? $algo[mt_rand(0, ($count - 1))] : throw new Exception("hash algorithm not found!");
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        if (isset($algo['options'])) {
            ($algo['options'] !== []) ? self::set_algo($algo['algo'])->set_options($algo['options']) : self::set_algo($algo['algo'])->set_default_options();
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
     * @method \IFaqih\IFEncryption\Component\Password\Main hash(string $str): string|false
     */
    public static function set_algo(string $algo): object
    {
        unset(static::$options['name']);
        unset(static::$options['algo']);
        unset(static::$options['algo_alias']);

        try {
            $obj = match ($algo) {
                PASSWORD_BCRYPT                         =>  new \IFaqih\IFEncryption\Component\Password\Method\A17(),
                PASSWORD_ARGON2I, PASSWORD_ARGON2ID     =>  new \IFaqih\IFEncryption\Component\Password\Method\A33A71($algo),
                default                                 =>  throw new Exception("hash algorithm not found!")
            };
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

        static::$options = is_array(static::$options) ? static::$options + $obj::___get_algo() : $obj::___get_algo();

        return $obj;
    }

    /**
     * Set to the default options set by php.
     *
     * @return \IFaqih\IFEncryption\Component\Password\Main
     * @method set_algo(string $algo): object
     * @method hash(string $str): string|false
     */
    public static function set_default_options(): object
    {
        static::$options['options'] = [];
        return self::getInstance();
    }

    /**
     * Executes hashing according to predefined algorithms and options.
     *
     * @param string $str String to be encrypted.
     * @return string|false Hashing result string or false.
     */
    public static function hash(string $str): string|false
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

            if (!isset(static::$options['algo']) && (isset(static::$options['options']) ? (static::$options['options'] === [] ? true : false) : false)) {
                self::set_rand_algo(array_column(static::$config, 'algo'));
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
     * @param int $rehash_flag Flag for automatic rehash. Available flags:
     *                         - DONT_REHASH: 1, indicates that rehashing should not be performed.
     *                         - REHASH_FIXED: 2, indicates that automatic rehashing should be performed.
     *                         - REHASH_CONFIG: 4, flag for rehashing with a configured algorithm or option.
     *                         - REHASH_BCRYPT: 8, flag for specific bcrypt rehashing algorithm.
     *                         - REHASH_ARGON2I: 16, flag for specific Argon2i rehashing algorithm.
     *                         - REHASH_ARGON2ID: 32, flag for specific Argon2id rehashing algorithm.
     *                         - REHASH_RAND_ALL_ALGO: 64, flag for rehashing with a random algorithm.
     *                         - REHASH_DEFAULT_OPTIONS: 128, flag for rehashing with default options.
     * @return bool Verification results.
     */
    public static function verify(string $str, string $existingHash, int $rehash_flag = REHASH_FIXED): bool
    {
        require_once __DIR__ . "/Verify.php";
        $obj = new \IFaqih\IFEncryption\Component\Password\Verify();
        $verify =  $obj->_verify($str, $existingHash);
        if (!($rehash_flag & DONT_REHASH)) {
            $options = static::$options;
            if ($rehash_flag > REHASH_FIXED) {
                self::set_rehash_options($rehash_flag);
            }

            $obj = new Encrypt();
            static::$new_hash = $obj->_encrypt($str);

            if (!$verify) {
                static::$new_hash = NULL;
            }
            static::$options = $options;
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
     * Get details of hash data.
     *
     * @return object Hash details.
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

    private static function set_rehash_options(int $flag): void
    {
        if ($flag >= REHASH_DEFAULT_OPTIONS) {
            if ($flag & REHASH_RAND_ALL_ALGO) {
                $options = static::password_algo;
            } else if ($flag >= (REHASH_DEFAULT_OPTIONS + REHASH_BCRYPT)) {
                $options = [];
                ($flag & REHASH_ARGON2ID) ? array_push($options, PASSWORD_ARGON2ID) : $options;
                ($flag & REHASH_ARGON2I) ? array_push($options, PASSWORD_ARGON2I) : $options;
                ($flag & REHASH_BCRYPT) ? array_push($options, PASSWORD_BCRYPT) : $options;

                $options = ($flag & REHASH_CONFIG) ? array_merge($options, array_filter(array_column(static::$config, "algo"), fn ($value) => !in_array($value, $options)))  : $options;
            } else {
                $options = ($flag & REHASH_CONFIG) ? array_column(static::$config, "algo") : [static::$options['algo']];
            }
            self::set_rand_algo($options)->set_default_options();
        } else if ($flag >= REHASH_RAND_ALL_ALGO) {
            if ($flag & REHASH_CONFIG) {
                $options = static::$config[mt_rand(0, (count(static::$config) - 1))];
            } else {
                $options = [
                    'algo'      =>  static::$options['algo'],
                    'options'   =>  static::$options['options']
                ];
            }
            self::set_rand_algo($options);
        } else {
            if ($flag > REHASH_CONFIG) {
                $algo = [];
                ($flag & REHASH_ARGON2ID) ? array_push($algo, PASSWORD_ARGON2ID) : $algo;
                ($flag & REHASH_ARGON2I) ? array_push($algo, PASSWORD_ARGON2I) : $algo;
                ($flag & REHASH_BCRYPT) ? array_push($algo, PASSWORD_BCRYPT) : $algo;
                $algo = array_filter($algo, fn ($value) => in_array($value, array_column(static::$config, 'algo')));
                if (isset($algo[0])) {
                    $options = static::$config[array_search($algo[mt_rand(0, (count($algo) - 1))], array_column(static::$config, 'algo'))];
                } else {
                    $options = array_search(static::$options['algo'], array_column(static::$config, 'algo'));
                    $options = $options != false ? static::$config[$options] : [
                        'algo'      =>  static::$options['algo'],
                        'options'   =>  static::$options['options']
                    ];
                }
            } else if ($flag & REHASH_CONFIG) {
                $options = static::$config[mt_rand(0, (count(static::$config) - 1))];
            } else {
                $options = [
                    'algo'      =>  static::$options['algo'],
                    'options'   =>  static::$options['options']
                ];
            }
            self::set_rand_algo($options);
        }
        return;
    }
}
