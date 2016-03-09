<?php

namespace Hyn\LetsEncrypt\Helpers;

use phpseclib\Crypt\RSA;
use Kelunik\Acme\KeyPair;

abstract class KeyPairGenerator
{
    public static function generate()
    {
        $keys = (new RSA())->createKey(4096);

        return new KeyPair($keys['privatekey'], $keys['publickey']);
    }
}
