# IFEncryption

IFEncryption is a simple library that serves to disguise the algorithm method along with options from [the password_hash function in php](https://www.php.net/manual/en/function.password-hash.php).

PHP Version: 8.0 or above
|-

## Installation

### With Composer:

```bash
composer require ifaqih/ifencryption
```

## Use The Library

```php
use IFaqih\IFEncryption\Password;
```

## Configuration

Configuration is useful for setting the default algorithm to be used and its options.

You can set the configuration in the if-encryption.php file in the config directory.

### Publish Configuration

In laravel you can also publish configuration file by doing php artisan command

```bash
php artisan vendor:publish
```

then select IFaqih\IFEncryption\ServiceProvider

### Configuration Array Format

```php
[
    [
        'algo'      =>  PASSWORD_BCRYPT,
        'options'   =>  [
            'cost'          =>  10
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
]
```

## Constants

All the constants used by this library.

### PHP Default Constants

Existing constants from php:

| Constant Name                         | Value        | Description                                                                                                                                                                          |
| ------------------------------------- | ------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `PASSWORD_BCRYPT`                     | `"2y"`       | Use the [CRYPT_BLOWFISH algorithm](https://www.php.net/security/crypt_blowfish) to create the hash                                                                                   |
| `PASSWORD_ARGON2I`                    | `"argon2i"`  | Use the [Argon2i hashing algorithm](https://wiki.php.net/rfc/argon2_password_hash) to create the hash. This algorithm is only available if PHP has been compiled with Argon2 support |
| `PASSWORD_ARGON2ID`                   | `"argon2id"` | Use the Argon2id hashing algorithm to create the hash. This algorithm is only available if PHP has been compiled with Argon2 support                                                 |
| `PASSWORD_BCRYPT_DEFAULT_COST`        | `10`         | Default cost set by php                                                                                                                                                              |
| `PASSWORD_ARGON2_DEFAULT_MEMORY_COST` | `65536`      | Default memory cost set by php                                                                                                                                                       |
| `PASSWORD_ARGON2_DEFAULT_TIME_COST`   | `4`          | Default time cost set by php                                                                                                                                                         |
| `PASSWORD_ARGON2_DEFAULT_THREADS`     | `1`          | Default threads set by php                                                                                                                                                           |

### Constants Added By The Library

Additional constants to support this library:

| Constant Name            | Value | Description                                                              |
| ------------------------ | ----- | ------------------------------------------------------------------------ |
| `DONT_REHASH`            | `1`   | Rehashing will not be performed                                          |
| `REHASH_FIXED`           | `2`   | Will perform rehashing based on available hashes                         |
| `REHASH_CONFIG`          | `4`   | Will perform rehashing based on the configuration that has been set      |
| `REHASH_BCRYPT`          | `8`   | Will perform rehashing using the CRYPT_BLOWFISH algorithm                |
| `REHASH_ARGON2I`         | `16`  | Will perform rehashing using the Argon2i algorithm                       |
| `REHASH_ARGON2ID`        | `32`  | Will perform rehashing using the Argon2id algorithm                      |
| `REHASH_RAND_ALL_ALGO`   | `64`  | Will perform the rehashing using one of all randomly selected algorithms |
| `REHASH_DEFAULT_OPTIONS` | `128` | Will do rehashing with default options from php                          |

## Class Methods

### Set Algorithm

Set of algorithms to be used.

```php
class::set_algo()
```

- Type: `static`
- Parameter data type: `string $algo`
- Return data type: `object`

### Set Random Algorithm

Which set of algorithms will be used, which will be randomly selected by the library.

```php
class::set_rand_algo()
```

- Type: `static`
- Parameter data type: `array $algo`
- Return data type: `object`

### Set Default Options

Set to the default options set by php.

```php
class::set_default_options()
```

- Type: `static`
- Parameter data type: no parameter
- Return data type: `object`

### Set Options

Set options of algorithms to be used.

```php
class::set_options()
```

- Type: `non-static`
- Parameter data type: `array $options`
- Return data type: `object`

### Set Time Cost

Set time cost of algorithms to be used.

```php
class::time_cost()
```

- Type: `non-static`
- Parameter data type: `int $time_cost`
- Return data type: `object`

_this class method only applies if you use ARGON2I and ARGON2ID algorithms_

### Set Memory Cost

Set memory cost of algorithms to be used.

```php
class::memory_cost()
```

- Type: `non-static`
- Parameter data type: `int $memory_cost`
- Return data type: `object`

_this class method only applies if you use ARGON2I and ARGON2ID algorithms_

### Set Threads

Set threads of algorithms to be used.

```php
class::threads()
```

- Type: `non-static`
- Parameter data type: `int $threads`
- Return data type: `object`

_this class method only applies if you use ARGON2I and ARGON2ID algorithms_

### Set Cost

Set cost of bcrypt to be used.

```php
class::cost()
```

- Type: `non-static`
- Parameter data type: `int $cost`
- Return data type: `object`

_this class method only applies if you use the BCRYPT algorithm_

### Execute Hashing

Executes hashing according to predefined algorithms and options.

```php
class::hash()
```

- Type: `static`
- Parameter data type: `string $str`
- Return data type: `string|false`

### Verify Hash

Verify string with existing hash.

```php
class::verify()
```

- Type: `static`
- Parameter data type: `string $str, string $existingHash, int $rehash_flag = REHASH_FIXED`
- Return data type: `bool`

_additional constants are useful as rehash flags in the verify() method_

### Get New Hash

Get the new hash after verify.

```php
class::new_hash()
```

- Type: `static`
- Parameter data type: no parameter
- Return data type: `string|null`

### Get Details Hash

Get details of hash data.

```php
class::get_details()
```

- Type: `static`
- Parameter data type: no parameter
- Return data type: `object`

### Get Algorithm Data

Get the algorithm data used.

```php
class::get_algo()
```

- Type: `static`
- Parameter data type: no parameter
- Return data type: `object`

### Get Option Data

Get the data of the options used.

```php
class::get_options()
```

- Type: `static`
- Parameter data type: no parameter
- Return data type: `object`

## Example

### Example 1:

- bcrypt example:

```php
use IFaqih\IFEncryption\Password;

$password = "@QweRty17@";

$hash = Password::set_algo(PASSWORD_BCRYPT)
    ->cost(10)
    ->hash($password);

$verify = Password::verify($password, $hash);

$new_hash = Password::new_hash();

$details = Password::get_details();

var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "new_hash"  =>  $new_hash,
    "verify"    =>  $verify,
    "details"   =>  $details
]);
```

- bcrypt example result:

```h
array(5) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(121) "$if-1$a17$1$UD3E+NwLQiO8RbdGZNkVhx8t14raoWkj7lP5BgVEVn$atg51mU6+V.n408Lm2DRq4$sL7kYzAGp/vOGt7sO6NafIvJ4RmJ6iYd30qMIou9nRC"
  ["new_hash"]=>
  string(121) "$if-1$a17$1$Vxws1l2U9jvnFOQDP5hWYtmJdsUIfod9MOuYYwWnk4$zyVrWCU80aKx0cOfzoCfR2$XNTmbEHnmXk.7r2t4opG5vl75wf.UWUyStOb1043ym2"
  ["verify"]=>
  bool(true)
  ["details"]=>
  object(stdClass)#2 (6) {
    ["library_name"]=>
    string(12) "IFEncryption"
    ["version"]=>
    string(3) "1.1"
    ["name"]=>
    string(6) "BCRYPT"
    ["algo"]=>
    string(2) "2y"
    ["algo_alias"]=>
    string(3) "a17"
    ["options"]=>
    object(stdClass)#1 (1) {
      ["cost"]=>
      string(2) "10"
    }
  }
}
```

- argon2 example:

```php
use IFaqih\IFEncryption\Password;

$password = "@QweRty17@";

$hash = Password::set_algo(PASSWORD_ARGON2ID)
    ->time_cost(7)
    ->memory_cost(512)
    ->threads(2)
    ->hash($password);

$verify = Password::verify($password, $hash);

$new_hash = Password::new_hash();

$details = Password::get_details();

var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "new_hash"  =>  $new_hash,
    "verify"    =>  $verify,
    "details"   =>  $details
]);
```

- argon2 example result:

```h
array(5) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(121) "$if-1$a71$1$2zgzrE78uooXLI5lCDT3bANWRBbTJDUzA1VENmbUE9$VGJZUDh1VnE3QU5XOElXbA$N7W5M3KvPFCX7b6rh9K7q/9Prx8MqAWvzvrPp0AE6k4"
  ["new_hash"]=>
  string(121) "$if-1$a71$1$9VxzqiVFYc3+H62OdrCttQeVVRczVwY3l6YmZxR3c9$eFVadXAzYjNxMU8wZmJ1OQ$P4794BWMmQ8mrmrRFQ8a64PB9dVx1e9ZdD1UeAcpWeM"
  ["verify"]=>
  bool(true)
  ["details"]=>
  object(stdClass)#4 (6) {
    ["library_name"]=>
    string(12) "IFEncryption"
    ["version"]=>
    string(3) "1.1"
    ["name"]=>
    string(8) "ARGON2ID"
    ["algo"]=>
    string(8) "argon2id"
    ["algo_alias"]=>
    string(3) "a71"
    ["options"]=>
    object(stdClass)#3 (3) {
      ["time_cost"]=>
      string(1) "7"
      ["memory_cost"]=>
      string(3) "512"
      ["threads"]=>
      string(1) "2"
    }
  }
}
```

### Example 2:

- example:

```php
use IFaqih\IFEncryption\Password;

$password = "@QweRty17@";

$hash = Password::set_algo(PASSWORD_ARGON2ID)
    ->set_options([
        'time_cost'     =>  11,
        'memory_cost'   =>  128,
        'threads'       =>  2
    ])
    ->hash($password);

$verify = Password::verify($password, $hash);

$new_hash = Password::new_hash();

$algo = Password::get_algo();

$options = Password::get_options();

var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "new_hash"  =>  $new_hash,
    "verify"    =>  $verify,
    "algo"      =>  $algo,
    "options"   =>  $options
]);
```

- result:

```h
array(6) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(121) "$if-1$a71$1$tiq/kvy2YYvcrZpjmP7VUANG1hWEtlYUpXQmpmUHpz$V1VyMEI3anc3cFlYZUFDVw$T2NS4hBRy5WABU8M9hikIQUG5xLisv85lcRZUpWeN10"
  ["new_hash"]=>
  string(121) "$if-1$a71$1$pgrPfa7+kORMJVSaWm1PZgb0s4ZWNoaFFCNDI3VjZz$QUk3a1lDL09nNkNxTDUwYg$kL15qrG1QcYp0NE2axbwbcaQGzqHckx7f4X8oZxljC0"
  ["verify"]=>
  bool(true)
  ["algo"]=>
  object(stdClass)#3 (3) {
    ["algo_name"]=>
    string(8) "ARGON2ID"
    ["algo"]=>
    string(8) "argon2id"
    ["alias"]=>
    string(3) "a71"
  }
  ["options"]=>
  object(stdClass)#1 (3) {
    ["time_cost"]=>
    string(2) "11"
    ["memory_cost"]=>
    string(3) "128"
    ["threads"]=>
    string(1) "2"
  }
}
```

### Example 3:

Example with set_rand_algo() method

- example:

```php
use IFaqih\IFEncryption\Password;

$password = "@QweRty17@";

$hash = Password::set_rand_algo([
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
])->hash($password);

var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "verify"    =>  Password::verify($password, $hash),
    "new_hash"  =>  Password::new_hash(),
    "details"   =>  Password::get_details()
]);
```

- result:

```h
array(5) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(121) "$if-1$a33$1$J8c6q6Hz804pRUiB950SEQUEROSVBKNkJDSmROUnc9$V1U2ZWpELm90VVNzOWx6Mg$VJWOi8X9e8WVw+VTIkyzxoZwgtQeaoX3OUrUr6IsDZE"
  ["verify"]=>
  bool(true)
  ["new_hash"]=>
  string(121) "$if-1$a33$1$WzmMwomINKJFXs+DYSi3tgc0hlME1NV0JFbnNWbkE9$STZ6eHpwaXpKc283U2M0aQ$qsrPOgRtiT5mRtFjZVSd3ggrZ9jRK/IM4LHK90DFlQo"
  ["details"]=>
  object(stdClass)#3 (6) {
    ["library_name"]=>
    string(12) "IFEncryption"
    ["version"]=>
    string(3) "1.1"
    ["name"]=>
    string(7) "ARGON2I"
    ["algo"]=>
    string(7) "argon2i"
    ["algo_alias"]=>
    string(3) "a33"
    ["options"]=>
    object(stdClass)#1 (3) {
      ["time_cost"]=>
      string(1) "3"
      ["memory_cost"]=>
      string(3) "128"
      ["threads"]=>
      string(1) "1"
    }
  }
}
```

### Example 4:

Example with config file and set_algo() method

- config file:

```php
return [
    [
        'algo'      =>  PASSWORD_BCRYPT,
        'options'   =>  [
            'cost'      =>  10
        ]
    ],
    [
        'algo'      =>  PASSWORD_ARGON2I,
        'options'   =>  [
            'time_cost'     =>  7,
            'memory_cost'   =>  512,
            'threads'       =>  2
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
```

- exmaple:

```php
use IFaqih\IFEncryption\Password;

$password = "@QweRty17@";

$hash = Password::set_algo(PASSWORD_ARGON2I)->hash($password);

var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "verify"    =>  Password::verify($password, $hash),
    "new_hash"  =>  Password::new_hash(),
    "details"   =>  Password::get_details()
]);
```

- result:

```h
array(5) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(121) "$if-1$a33$1$jX+spw/1+h0oYXf7swevQgREU3Mm1FQzJXNDJrYWc9$Tzdxekl5eDNUS2MvTm9qRw$fLMUtlD7qMmx2QroW/Mi837GnRhRaKhwVOafKlLtEGY"
  ["verify"]=>
  bool(true)
  ["new_hash"]=>
  string(121) "$if-1$a33$1$HKW+qWoADBYc4YHlecWEmwdWZ6aWVuTDJjTGY1cnc9$c2FzR3JSVS91azFBeGxjMw$k32P/nyuPp/sUZ8e0yHYR+4hKruOjXKgk1M2lv2KYjc"
  ["details"]=>
  object(stdClass)#3 (6) {
    ["library_name"]=>
    string(12) "IFEncryption"
    ["version"]=>
    string(3) "1.1"
    ["name"]=>
    string(7) "ARGON2I"
    ["algo"]=>
    string(7) "argon2i"
    ["algo_alias"]=>
    string(3) "a33"
    ["options"]=>
    object(stdClass)#1 (3) {
      ["time_cost"]=>
      string(1) "7"
      ["memory_cost"]=>
      string(3) "512"
      ["threads"]=>
      string(1) "2"
    }
  }
}
```

### Example 5:

In this example if there is more than one algorithm in the config array, it will be chosen randomly by the library.

- config file:

```php
return [
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
            'memory_cost'   =>  512,
            'threads'       =>  1
        ]
    ],
    [
        'algo'      =>  PASSWORD_ARGON2ID,
        'options'   =>  [
            'time_cost'     =>  5,
            'memory_cost'   =>  128,
            'threads'       =>  2
        ]
    ]
];
```

- exmaple:

```php
use IFaqih\IFEncryption\Password;

$password = "@QweRty17@";

$hash = Password::hash($password);

echo "<pre>";
var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "verify"    =>  Password::verify($password, $hash, REHASH_CONFIG),
    "new_hash"  =>  Password::new_hash(),
    "details"   =>  Password::get_details()
]);
```

- result:

```h
array(5) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(121) "$if-1$a33$1$YFjx3IuQfzZSwMH6EPID/wYkhIT05iYVFlYTRPUXc9$VjZBeXo3UVlGMGpSZGJ2YQ$FGxqCE7egVbChGM6BkEQpAFvHCguqmDbKg5PZ+13eq0"
  ["verify"]=>
  bool(true)
  ["new_hash"]=>
  string(121) "$if-1$a71$1$P2QP9jegKuxPFSe3KzP/lwNWtzZzJ3TFBJaWhZVWc9$Wmtua1NQcndSdDk5czlaZg$5TUocfts4VHyo4y/1cP+AmhJMknWWZ5GGElilXHw3O4"
  ["details"]=>
  object(stdClass)#3 (6) {
    ["library_name"]=>
    string(12) "IFEncryption"
    ["version"]=>
    string(3) "1.1"
    ["name"]=>
    string(7) "ARGON2I"
    ["algo"]=>
    string(7) "argon2i"
    ["algo_alias"]=>
    string(3) "a33"
    ["options"]=>
    object(stdClass)#2 (3) {
      ["time_cost"]=>
      string(1) "3"
      ["memory_cost"]=>
      string(3) "512"
      ["threads"]=>
      string(1) "1"
    }
  }
}
```

### Example 6:

In this example the library will only apply the algorithm in the configuration file while the options will be overridden by the default options from php.

- config file:

```php
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
```

- example:

```php
use IFaqih\IFEncryption\Password;

$password = "@QweRty17@";

$hash = Password::set_default_options()->hash($password);

var_dump([
    "password"  =>  $password,
    "hash"      =>  [
        "hash"      =>  $hash,
        "verify"    =>  Password::verify($password, $hash, REHASH_CONFIG | REHASH_DEFAULT_OPTIONS),
        "details"   =>  Password::get_details()
    ],
    "new_hash"  =>  [
        "hash"      =>  Password::new_hash(),
        "verify"    =>  Password::verify($password, Password::new_hash(), DONT_REHASH),
        "details"   =>  Password::get_details()
    ]
]);
```

- result:

```h
array(3) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  array(3) {
    ["hash"]=>
    string(121) "$if-1$a17$1$/V.EIGg8+Ol6aQ19Z9sSQ+MSxErw+J/RZvl1cwdytj$Rky.t0f5+4Bb.VCsOXOKDL$FI0meC0X1m0e/v83y5RRrQzLSyrz/qCbJb7bvskvEzC"
    ["verify"]=>
    bool(true)
    ["details"]=>
    object(stdClass)#3 (6) {
      ["library_name"]=>
      string(12) "IFEncryption"
      ["version"]=>
      string(3) "1.1"
      ["name"]=>
      string(6) "BCRYPT"
      ["algo"]=>
      string(2) "2y"
      ["algo_alias"]=>
      string(3) "a17"
      ["options"]=>
      object(stdClass)#2 (1) {
        ["cost"]=>
        string(2) "10"
      }
    }
  }
  ["new_hash"]=>
  array(3) {
    ["hash"]=>
    string(123) "$if-1$a33$1$g5o0gHM1LD7ydpOkGB71NwYjJCOFBXaVNKZTRWb3lhUA$NFd6LnJ1d1RxZHhSV3cxUw$Le/64GIMIvRiQRjYZsVtA7wlqJ0h7ZEluuUF0zKDcKM"
    ["verify"]=>
    bool(true)
    ["details"]=>
    object(stdClass)#5 (6) {
      ["library_name"]=>
      string(12) "IFEncryption"
      ["version"]=>
      string(3) "1.1"
      ["name"]=>
      string(7) "ARGON2I"
      ["algo"]=>
      string(7) "argon2i"
      ["algo_alias"]=>
      string(3) "a33"
      ["options"]=>
      object(stdClass)#4 (3) {
        ["time_cost"]=>
        string(1) "4"
        ["memory_cost"]=>
        string(5) "65536"
        ["threads"]=>
        string(1) "1"
      }
    }
  }
}
```

### Example 7:

Example by using the set_rand_algo() and set_default_options() methods.

- example:

```php
use IFaqih\IFEncryption\Password;

$password = "@QweRty17@";

$hash = Password::set_rand_algo([
    PASSWORD_BCRYPT,
    PASSWORD_ARGON2I,
    PASSWORD_ARGON2ID
])->set_default_options()->hash($password);

var_dump([
    "password"  =>  $password,
    "hash"      =>  [
        "hash"      =>  $hash,
        "verify"    =>  Password::verify($password, $hash, REHASH_RAND_ALL_ALGO | REHASH_DEFAULT_OPTIONS),
        "details"   =>  Password::get_details()
    ],
    "new_hash"  =>  [
        "hash"      =>  Password::new_hash(),
        "verify"    =>  Password::verify($password, Password::new_hash(), DONT_REHASH),
        "details"   =>  Password::get_details()
    ]
]);
```

- result:

```h
array(3) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  array(3) {
    ["hash"]=>
    string(123) "$if-1$a33$1$Q8TNFrS1PvYBD3RTR19n5QaU42SjhwZnA2MUJkY2Y0WA$ekZpUnZ3eWNvL0I0RzhJMA$aufVjM1LXN/dbJI9r7ChgNuGkohex/lyb7BKFeD8nQ0"
    ["verify"]=>
    bool(true)
    ["details"]=>
    object(stdClass)#3 (6) {
      ["library_name"]=>
      string(12) "IFEncryption"
      ["version"]=>
      string(3) "1.1"
      ["name"]=>
      string(7) "ARGON2I"
      ["algo"]=>
      string(7) "argon2i"
      ["algo_alias"]=>
      string(3) "a33"
      ["options"]=>
      object(stdClass)#2 (3) {
        ["time_cost"]=>
        string(1) "4"
        ["memory_cost"]=>
        string(5) "65536"
        ["threads"]=>
        string(1) "1"
      }
    }
  }
  ["new_hash"]=>
  array(3) {
    ["hash"]=>
    string(121) "$if-1$a17$1$+sdGAqt1fEg.Z/vwEQk1K9SGhQ8q78l0DinyzgNnRV$G1Um.RP2ZnWQ4NzTDHnD6t$V0P7kIVPmzc.UXRrGRHbemO77/dLqMpsH0/9PaCp0lS"
    ["verify"]=>
    bool(true)
    ["details"]=>
    object(stdClass)#4 (6) {
      ["library_name"]=>
      string(12) "IFEncryption"
      ["version"]=>
      string(3) "1.1"
      ["name"]=>
      string(6) "BCRYPT"
      ["algo"]=>
      string(2) "2y"
      ["algo_alias"]=>
      string(3) "a17"
      ["options"]=>
      object(stdClass)#5 (1) {
        ["cost"]=>
        string(2) "10"
      }
    }
  }
}
```
