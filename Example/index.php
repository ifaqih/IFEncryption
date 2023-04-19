<?php

require_once __DIR__ . "/../src/Encryption.php";

use IFaqih\Library\Encryption;

$password = "kmzway87aa";
$bcrypt = Encryption::password(PASSWORD_BCRYPT, ['cost' => 14, 'salt_cost' => 'kmzway87aa'])->encrypt($password);
$argon2i = Encryption::password(PASSWORD_ARGON2I, [
    'time_cost'     =>  1300,
    'memory_cost'   =>  1024,
    'threads'       =>  2
])->encrypt($password);
$argon2id = Encryption::password(PASSWORD_ARGON2ID, [
    'time_cost'     =>  1300,
    'memory_cost'   =>  1024,
    'threads'       =>  2
])->encrypt($password);


$text = "Jika Anda menggunakan openssl_encrypt() dengan algoritma cipher seperti AES-128-CBC atau AES-256-CBC, panjang IV yang dibutuhkan adalah 16 byte atau 128 bit. Jika panjang IV yang digunakan lebih panjang dari 16 byte, maka akan muncul warning seperti yang Anda sebutkan.

Untuk mengatasi warning tersebut, pastikan bahwa panjang IV yang digunakan sesuai dengan algoritma cipher yang dipilih. Jika Anda ingin menggunakan IV yang lebih panjang, pilihlah algoritma cipher yang memungkinkan penggunaan IV dengan panjang yang lebih panjang, seperti AES-CTR.";

$aes = Encryption::text([
    'cipher'    =>  'aes-256-cbc',
    'key'       =>  '8edabc160435315bdec92adf4ce5d7519591545b673c82019ca920227d744490ee644afbfb93e7639869d0dd27089576',
    'option'    =>  OPENSSL_RAW_DATA
])->encrypt($text);


echo "<pre>";

var_dump([
    "BCRYPT"    =>  [
        "text"      =>  $password,
        "encrypt"   =>  $bcrypt,
        "valid"     =>  Encryption::password()->valid($password, $bcrypt, 'kmzway87aa')
    ]
]);

var_dump([
    "ARGON2I"   =>  [
        "text"      =>  $password,
        "encrypt"   =>  $argon2i,
        "valid"     =>  Encryption::password()->valid($password, $argon2i)
    ]
]);

var_dump([
    "ARGON2ID"  =>  [
        "text"      =>  $password,
        "encrypt"   =>  $argon2id,
        "valid"     =>  Encryption::password()->valid($password, $argon2id)
    ]
]);

var_dump([
    "AES-CBC"   => [
        "text"      =>  $text,
        "encrypt"   =>  $aes->return,
        "decrypt"   =>  Encryption::text([
            'cipher'    =>  'aes-256-cbc',
            'key'       =>  '8edabc160435315bdec92adf4ce5d7519591545b673c82019ca920227d744490ee644afbfb93e7639869d0dd27089576',
            'option'    =>  OPENSSL_RAW_DATA
        ])->decrypt($aes->return, $aes->iv)
    ]
]);

echo "<pre>";
