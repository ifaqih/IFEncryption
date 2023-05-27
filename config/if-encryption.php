<?php

return [
    [
        'algo'      =>  PASSWORD_BCRYPT,
        'options'   =>  [
            'cost'          =>  7
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
];
