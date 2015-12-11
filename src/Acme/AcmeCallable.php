<?php namespace Hyn\LetsEncrypt\Acme;

trait AcmeCallable {
    /**
     * @return Client
     */
    public function acme()
    {
        return (new Client());
    }
}