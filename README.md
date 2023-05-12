# IFEncryption

IFEncryption is a simple library that serves to disguise the algorithm method along with options from the password_hash function in php.

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

_[this class method only applies if you use ARGON2I and ARGON2ID algorithms]_

### Set Memory Cost

Set memory cost of algorithms to be used.

```php
class::memory_cost()
```

- Type: `non-static`
- Parameter data type: `int $memory_cost`
- Return data type: `object`

_[this class method only applies if you use ARGON2I and ARGON2ID algorithms]_

### Set Threads

Set threads of algorithms to be used.

```php
class::threads()
```

- Type: `non-static`
- Parameter data type: `int $threads`
- Return data type: `object`

_[this class method only applies if you use ARGON2I and ARGON2ID algorithms]_

### Set Cost

Set cost of bcrypt to be used.

```php
class::cost()
```

- Type: `non-static`
- Parameter data type: `int $cost`
- Return data type: `object`

_[this class method only applies if you use the BCRYPT algorithm]_

### Execute Encryption

Execute the encryption command according to the algorithm and options that have been set.

```php
class::encrypt()
```

- Type: `static`
- Parameter data type: `string $str`
- Return data type: `string|false`

### Verify Encryption

Verify string with existing hash.

```php
class::verify()
```

- Type: `static`
- Parameter data type: `string $str, string $existingHash, bool $rehash = TRUE`
- Return data type: `bool`

### Get New Hash

Get the new hash after verify.

```php
class::new_hash()
```

- Type: `static`
- Parameter data type: no parameter
- Return data type: `string|null`

### Get Details Encryption

Get encryption data details.

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
    ->encrypt($password);

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
  string(94) "$if-1$a17$1$fs9iKTE8fal5mmUkHkGRtwVjRVPQ$FHtbkJ4TMz5GAOA.zBfqA.lLXnGVJtbNuPHmivnxN8mqrjuRSjIR2"
  ["new_hash"]=>
  string(94) "$if-1$a17$1$SEHSn2yIxum4tFHoJJW8DgUnNVPQ$l0oD4gJO5zvQj.cePu9yD.btzAc.MUy9LvUbh25GNOYStpU7YQvWm"
  ["verify"]=>
  bool(true)
  ["details"]=>
  object(stdClass)#1 (6) {
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
```

- argon2 example:

```php
use IFaqih\IFEncryption\Password;

$password = "@QweRty17@";

$hash = Password::set_algo(PASSWORD_ARGON2ID)
    ->time_cost(7)
    ->memory_cost(128)
    ->threads(1)
    ->encrypt($password);

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
  string(123) "$if-1$a71$1$eX7TAUjiDI/Yjb9BhlyBoQVjErWlptdU50Q28rcUE9PQ$cS5nVXBIQUQvWVdOLkxsQQ$CApfsEpKFtiHc4rIIAjK0ylcN6Yyj+2KuF2VDGMti1g"
  ["new_hash"]=>
  string(123) "$if-1$a71$1$x0myZUtO6jpVMNm7HtcEnQRjJOa09SQ0p1eW1tVkE9PQ$QVdCbVBwREZ0cWIuWFBiTQ$ZloK+r2nNYhU/M5KsuNWcAPduqHGbS63tfEuhziEcTI"
  ["verify"]=>
  bool(true)
  ["details"]=>
  object(stdClass)#1 (6) {
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
    object(stdClass)#2 (3) {
      ["time_cost"]=>
      string(1) "7"
      ["memory_cost"]=>
      string(3) "128"
      ["threads"]=>
      string(1) "1"
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
        'time_cost'     =>  3,
        'memory_cost'   =>  128,
        'threads'       =>  1
    ])
    ->encrypt($password);

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
  string(123) "$if-1$a71$1$azlQgtVORNtnTFGpc0xK2gUGdEc2lSenF2bm5RakE9PQ$MFlObXQuUXZVbFYuSElzMA$ZW6s01RZsuOgY9HiyiNpaxl7v838kGjpuEDFyOYzzDQ"
  ["new_hash"]=>
  string(123) "$if-1$a71$1$n19VRHtG5J+ryTg1loreiwdzBFN3dwS3VGSXczVkE9PQ$WElhNjhsMC5yT3RCYXladQ$xSTSBiTgJZjpo47glV4OwQJk8pSiaRqb6QGuDJGQ46Q"
  ["verify"]=>
  bool(true)
  ["algo"]=>
  object(stdClass)#1 (3) {
    ["algo_name"]=>
    string(8) "ARGON2ID"
    ["algo"]=>
    string(8) "argon2id"
    ["alias"]=>
    string(3) "a71"
  }
  ["options"]=>
  object(stdClass)#2 (3) {
    ["time_cost"]=>
    string(1) "3"
    ["memory_cost"]=>
    string(3) "128"
    ["threads"]=>
    string(1) "1"
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
])->encrypt($password);

var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "new_hash"  =>  Password::verify($password, $hash),
    "verify"    =>  Password::new_hash(),
    "details"   =>  Password::get_details()
]);
```

- result:

```h
array(5) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(94) "$if-1$a17$1$maSXnW36DcarZ5aHoW9RTgbHU0PQ$k.138hkpLHdvoNsD0NpnEuXArEaLKjNzhCb0rFUtGv0nBjN14eG.m"
  ["new_hash"]=>
  bool(true)
  ["verify"]=>
  string(94) "$if-1$a17$1$Tvb4ra+veaem88GAIXoq5QeitNPQ$fW5S1oHeHnrMSkenNVBTf.aeHeLgS0bhPzo.Uty8ZSQP1vhQamIii"
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
    object(stdClass)#3 (1) {
      ["cost"]=>
      string(2) "10"
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

$hash = Password::set_algo(PASSWORD_ARGON2I)->encrypt($password);

var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "new_hash"  =>  Password::verify($password, $hash),
    "verify"    =>  Password::new_hash(),
    "details"   =>  Password::get_details()
]);
```

- result:

```h
array(5) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(123) "$if-1$a33$1$29dpJNigh4yCAo/JR/ut1wSVBLNnBGM2RSMUdQMnc9PQ$SXlFZGlsUXljWXJkbldaRg$Q8ZLyL8ES9zbBt/AFf/ewrTWrC6dmKG7/xT36x0/Nq0"
  ["new_hash"]=>
  bool(true)
  ["verify"]=>
  string(123) "$if-1$a33$1$gu9dJ6vVGa8eDrZ2dRnEegUHF6UFVCNU1Fb3Z1a0E9PQ$emo2Qk1OZUxxcjhjUHRNeQ$zegRjk0/fvyVOgMiVRdUtlbjElMKyPe2BS0PBBK/rGc"
  ["details"]=>
  object(stdClass)#1 (6) {
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

$hash = Password::encrypt($password);

echo "<pre>";
var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "new_hash"  =>  Password::verify($password, $hash),
    "verify"    =>  Password::new_hash(),
    "details"   =>  Password::get_details()
]);
```

- result:

```h
array(5) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(123) "$if-1$a71$1$Z4yFlCcF6Iw3bbATILltwwK1JOTEl0RXVZZjVTc2c9PQ$SmZoNDY2RjJaZjJBR08xcQ$4QffiL/xfGz+BI8BN3YhsozpQ2s0ojz51k3lHyO7sSA"
  ["new_hash"]=>
  bool(true)
  ["verify"]=>
  string(123) "$if-1$a71$1$3RlJTBNM5vOeKDB5HcW6eQang1UmdHL0wxUVQ4c0E9PQ$bHJKSWh5LzgyWnluVExGOA$J3py6UrVtRKxtubIF09f5fon5Bj9844YRFgQLyE2qfc"
  ["details"]=>
  object(stdClass)#2 (6) {
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
      string(1) "5"
      ["memory_cost"]=>
      string(3) "128"
      ["threads"]=>
      string(1) "2"
    }
  }
}
```

### Example 6:

In this example the library will ignore the options in the config file and will apply the default options from php.

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

$hash = Password::set_default_options()->encrypt($password);

var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "new_hash"  =>  Password::verify($password, $hash),
    "verify"    =>  Password::new_hash(),
    "details"   =>  Password::get_details()
]);
```

- result:

```h
array(5) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(123) "$if-1$a33$1$HLbwmapOMM3goQy612uavgVlZTaXpudHJoeXN0eWMydQ$dUFsR0YzQmlKTVBqOHQuaA$kOOl3/uj4POet72b2zw+RkOV3M6D3rSpX6ozhSYHJ4g"
  ["new_hash"]=>
  bool(true)
  ["verify"]=>
  string(123) "$if-1$a33$1$tOY9gQTqvDC1EPYzN6wIIwaVc3R252QVpYVU1MWTI4eg$VDZVbVFNSFFyamNDeFFYWA$2M40tBCYXQO2xb57nDchOj65G/K2ZzmkHBc/vg4zDR8"
  ["details"]=>
  object(stdClass)#2 (6) {
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
    object(stdClass)#3 (3) {
      ["time_cost"]=>
      string(1) "4"
      ["memory_cost"]=>
      string(5) "65536"
      ["threads"]=>
      string(1) "1"
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
])->set_default_options()->encrypt($password);

var_dump([
    "password"  =>  $password,
    "hash"      =>  $hash,
    "new_hash"  =>  Password::verify($password, $hash),
    "verify"    =>  Password::new_hash(),
    "details"   =>  Password::get_details()
]);
```

- result:

```h
array(5) {
  ["password"]=>
  string(10) "@QweRty17@"
  ["hash"]=>
  string(123) "$if-1$a33$1$eICf/Jb8+Ejl+ewPSaWwkQd2p5TFNwVHZJVDErbXY1SQ$NFZHR1pyaHdwYXJUdzg2Rg$I2gGt7x8OISUahLfu125EtKVTjunb8bCrhK0egsI1OQ"
  ["new_hash"]=>
  bool(true)
  ["verify"]=>
  string(123) "$if-1$a33$1$Fo2rYOIS/0oxOkHbFD5ZzQbEhianBaYVFiMy95Nm9SNQ$M0ZaVTMzL25xeXNZYjhRVQ$Wzhf5HNT4TtrZ96Eqs/8Z3AnLi+FXDYYSAfSV19DGXw"
  ["details"]=>
  object(stdClass)#2 (6) {
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
    object(stdClass)#3 (3) {
      ["time_cost"]=>
      string(1) "4"
      ["memory_cost"]=>
      string(5) "65536"
      ["threads"]=>
      string(1) "1"
    }
  }
}
```
