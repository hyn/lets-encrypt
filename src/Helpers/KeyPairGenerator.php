<?php

namespace Hyn\LetsEncrypt\Helpers;

use Crypt_RSA;
use Kelunik\Acme\KeyPair;

abstract class KeyPairGenerator
{
    public static function generate()
    {
        $keys = (new Crypt_RSA())->createKey(4096);

        return new KeyPair($keys['privatekey'], $keys['publickey']);
    }
}
