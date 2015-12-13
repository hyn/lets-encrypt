<?php namespace Hyn\LetsEncrypt\Acme;

trait AcmeCallable {

    /**
     * @var null|Client
     */
    static protected $acmeClient;

    /**
     * @return Client
     */
    public function acme()
    {
        if(!static::$acmeClient)
        {
            static::$acmeClient = (new Client());
        }
        return static::$acmeClient;
    }
}