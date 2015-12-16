<?php

namespace Hyn\LetsEncrypt\Acme;

trait AcmeCallable
{
    /**
     * @var null|Client
     */
    protected static $acmeClient;

    /**
     * @return Client
     */
    public function acme()
    {
        if (!static::$acmeClient) {
            static::$acmeClient = (new Client());
        }

        return static::$acmeClient;
    }
}
