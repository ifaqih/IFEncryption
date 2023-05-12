<?php

require_once __DIR__ . "/../src/Password.php";

use IFaqih\IFEncryption\Password;

class Testing
{

    private static $count;

    public function __construct(int $count)
    {
        static::$count = $count;
    }

    public function strat()
    {
        $count_t = 0;
        $count_algo = [
            "bcrypt"    =>  0,
            "argon2i"   =>  0,
            "argon2id"  =>  0
        ];
        $error = array();

        for ($i = 0; $i < static::$count; $i++) {
            $test = Password::set_rand_algo([
                [
                    'algo'      =>  PASSWORD_BCRYPT,
                    'options'   =>  [
                        'cost'      =>  7
                    ]
                ],
                [
                    'algo'      =>  PASSWORD_ARGON2I,
                    'options'   =>  [
                        'time_cost'     =>  3,
                        'memory_cost'   =>  128,
                        'threads'       =>  4
                    ]
                ],
                [
                    'algo'      =>  PASSWORD_ARGON2ID,
                    'options'   =>  [
                        'time_cost'     =>  3,
                        'memory_cost'   =>  128,
                        'threads'       =>  4
                    ]
                ]
            ]);
            $str = $this->rand_str();
            $hash = $test->encrypt($str);

            if (Password::verify($str, $hash, FALSE)) {
                $count_t++;
                switch (Password::get_algo()->algo) {
                    case PASSWORD_BCRYPT:
                        $count_algo['bcrypt']++;
                        break;
                    case PASSWORD_ARGON2I:
                        $count_algo['argon2i']++;
                        break;
                    case PASSWORD_ARGON2ID:
                        $count_algo['argon2id']++;
                        break;
                    default:
                        break;
                }
            } else {
                $error[] = [
                    "algo"      =>  Password::get_algo()->algo,
                    "string"    =>  $str,
                    "iteration" =>  $i + 1
                ];
            }
        }

        return [
            "true"          =>  $count_t,
            "false"         =>  count($error),
            "count_algo"    =>  $count_algo,
            "error"         =>  $error
        ];
    }

    public function rand_str(): string
    {
        $int_rand = mt_rand(8, 35);
        return substr(base64_encode(openssl_random_pseudo_bytes($int_rand)), 0, $int_rand);
    }
}

$test = new Testing(1000);

echo "<pre>";
var_dump($test->strat());
echo "</pre>";
