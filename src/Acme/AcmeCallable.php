<?php namespace Hyn\LetsEncrypt\Acme;

trait AcmeCallable {
    /**
     * @return Client
     */
    protected function acme()
    {
        return (new Client());
    }
}