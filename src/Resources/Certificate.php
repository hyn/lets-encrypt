<?php namespace Hyn\LetsEncrypt\Resources;

class Certificate
{
    /**
     * Hostnames of the certificate.
     *
     * @var array
     */
    protected $hostnames = [];

    /**
     * @var Account
     */
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Add a hostname for a certificate request.
     *
     * @param $hostname
     * @return $this
     */
    public function addHostname($hostname)
    {
        if (!in_array($hostname, $this->hostnames)) {
            $this->hostnames[] = $hostname;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getHostnames()
    {
        return $this->hostnames;
    }


    public function request()
    {
        $location = $this->account->acme()->requestCertificate($this->account->acme()->getKeyPair(), $this->hostnames);
        return $location;
    }
}