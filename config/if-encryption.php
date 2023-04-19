<?php

return [
    'password'  =>  [
        //     'use'       =>  PASSWORD_BCRYPT,
        //     'options'   =>  [
        //         'cost'      =>  14,
        //         'salt_cost' =>  'kmzway87aa'
        //     ]

        'use'       =>  PASSWORD_ARGON2I,
        'options'   =>  [
            'time_cost'     =>  1300,
            'memory_cost'   =>  1024,
            'threads'       =>  2
        ]

        // 'use'       =>  PASSWORD_ARGON2ID,
        // 'options'   =>  [
        //     'time_cost'     =>  1300,
        //     'memory_cost'   =>  1024,
        //     'threads'       =>  2
        // ]
    ],
    'text'      =>  [
        'cipher'    =>  'aes-256-cbc',
        'key'       =>  '8edabc160435315bdec92adf4ce5d7519591545b673c82019ca920227d744490ee644afbfb93e7639869d0dd27089576',
        'option'    =>  OPENSSL_RAW_DATA
    ]
];
