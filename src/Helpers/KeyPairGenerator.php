<?php

namespace Hyn\LetsEncrypt\Helpers;

use Kelunik\Acme\KeyPair;
use phpseclib\Crypt\RSA;

abstract class KeyPairGenerator
{
    public static function generate()
    {
        $keys = (new RSA())->createKey(4096);

        return new KeyPair($keys['privatekey'], $keys['publickey']);
    }
}
