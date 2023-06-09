<?php
require_once __DIR__ . "/../src/Password.php";

use IFaqih\IFEncryption\Password;

$str_bcrypt = rand_str();
$s = microtime(true);
$custom_bcrypt = Password::set_algo(PASSWORD_BCRYPT)
    ->cost(10)
    ->hash($str_bcrypt);
$time_custom_bcrypt = microtime(true) - $s;

$s = microtime(true);
$bcrypt = password_hash($str_bcrypt, PASSWORD_BCRYPT, ['cost' =>  10]);
$time_bcrypt = microtime(true) - $s;



$str_argon2i = rand_str();
$s = microtime(true);
$custom_argon2i = Password::set_algo(PASSWORD_ARGON2I)->time_cost(3)->memory_cost(128)->threads(1)->hash($str_argon2i);
$time_custom_argon2i = microtime(true) - $s;

$s = microtime(true);
$argon2i = password_hash($str_argon2i, PASSWORD_ARGON2I, [
    'time_cost'     =>  3,
    'memory_cost'   =>  128,
    'threads'       =>  1
]);
$time_argon2i = microtime(true) - $s;



$str_argon2id = rand_str();
$s = microtime(true);
$custom_argon2id = Password::set_algo(PASSWORD_ARGON2ID)->time_cost(3)->memory_cost(128)->threads(1)->hash($str_argon2id);
$time_custom_argon2id = microtime(true) - $s;

$s = microtime(true);
$argon2id = password_hash($str_argon2id, PASSWORD_ARGON2ID, [
    'time_cost'     =>  3,
    'memory_cost'   =>  128,
    'threads'       =>  1
]);
$time_argon2id = microtime(true) - $s;



$str_config_algo = rand_str();
$s = microtime(true);
$config_file_algo = Password::set_algo(PASSWORD_ARGON2ID)->set_default_options()->hash($str_config_algo);
$time_config_file_algo = microtime(true) - $s;



$str_rand_algo = rand_str();
$s = microtime(true);
$rand_algo = Password::set_rand_algo([
    [
        'algo'      =>  PASSWORD_BCRYPT,
        'options'   =>  [
            'cost'      =>  10
        ]
    ],
    [
        'algo'      =>  PASSWORD_ARGON2I,
        'options'   =>  [
            'time_cost'     =>  3,
            'memory_cost'   =>  128,
            'threads'       =>  1
        ]
    ],
    [
        'algo'      =>  PASSWORD_ARGON2ID,
        'options'   =>  [
            'time_cost'     =>  3,
            'memory_cost'   =>  128,
            'threads'       =>  1
        ]
    ]
])->hash($str_rand_algo);
$time_rand_algo = microtime(true) - $s;


echo "<pre>";

var_dump([
    "BCRYPT"    =>  [
        "text"              =>  $str_bcrypt,
        "hash"           =>  [
            "basic_hash"     =>  $bcrypt,
            "custom_hash"    =>  $custom_bcrypt,
        ],
        "time"              =>  [
            "basic"         =>  $time_bcrypt,
            "custom"        =>  $time_custom_bcrypt
        ],
        "verify"            =>  Password::verify($str_bcrypt, $custom_bcrypt, DONT_REHASH)
    ]
]);

var_dump([
    "ARGON2I"   =>  [
        "text"              =>  $str_argon2i,
        "hash"           =>  [
            "basic_hash"     =>  $argon2i,
            "custom_hash"    =>  $custom_argon2i,
        ],
        "time"              =>  [
            "basic"         =>  $time_argon2i,
            "custom"        =>  $time_custom_argon2i
        ],
        "verify"            =>  Password::verify($str_argon2i, $custom_argon2i, DONT_REHASH)
    ]
]);

var_dump([
    "ARGON2ID"  =>  [
        "text"              =>  $str_argon2id,
        "hash"           =>  [
            "basic_hash"     =>  $argon2id,
            "custom_hash"    =>  $custom_argon2id,
        ],
        "time"              =>  [
            "basic"         =>  $time_argon2id,
            "custom"        =>  $time_custom_argon2id
        ],
        "verify"            =>  Password::verify($str_argon2id, $custom_argon2id, DONT_REHASH)
    ]
]);

var_dump([
    "CONFIG_FILE_ALGO"  =>  [
        "text"              =>  $str_config_algo,
        "custom_hash"    =>  $config_file_algo,
        "time_custom"       =>  $time_config_file_algo,
        "verify"            =>  Password::verify($str_config_algo, $config_file_algo, DONT_REHASH),
        "detail"            =>  Password::get_details()
    ]
]);

var_dump([
    "RANDOM_ALGO"  =>  [
        "text"              =>  $str_rand_algo,
        "custom_hash"       =>  $rand_algo,
        "time_custom"       =>  $time_rand_algo,
        "verify"            =>  Password::verify($str_rand_algo, $rand_algo),
        "detail"            =>  Password::get_details(),
        "new_hash"          =>  Password::new_hash()
    ]
]);

function rand_str(): string
{
    $int_rand = mt_rand(8, 35);
    return substr(base64_encode(openssl_random_pseudo_bytes($int_rand)), 0, $int_rand);
}
