<?php

namespace IFaqih\IFEncryption\Component\Password\Method;

use IFaqih\IFEncryption\Component\Password\Main;

abstract class AbstractMethod extends Main
{

    protected const algo = [
        PASSWORD_BCRYPT     =>  [
            "name"          =>  "BCRYPT",
            "algo"          =>  PASSWORD_BCRYPT,
            "algo_alias"    =>  "a17"
        ],
        PASSWORD_ARGON2I    =>  [
            "name"          =>  "ARGON2I",
            "algo"          =>  PASSWORD_ARGON2I,
            "algo_alias"    =>  "a33"
        ],
        PASSWORD_ARGON2ID   =>  [
            "name"          =>  "ARGON2ID",
            "algo"          =>  PASSWORD_ARGON2ID,
            "algo_alias"    =>  "a71"
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set options of algorithms to be used.
     *
     * @param string $algo Algorithm to be used.
     * @return \IFaqih\IFEncryption\Component\Password\Main|\IFaqih\IFEncryption\Component\Password\Method\A17|\IFaqih\IFEncryption\Component\Password\Method\A33A71
     */
    abstract public function set_options(array $options): object;

    abstract protected static function ___get_algo(): array;
}
