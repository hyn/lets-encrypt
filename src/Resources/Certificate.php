<?php namespace Hyn\LetsEncrypt\Resources;

use Hyn\LetsEncrypt\Helpers\KeyPairGenerator;

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

    /**
     * @return mixed
     */
    public function request()
    {
        $location = $this->account->acme()->requestCertificate(KeyPairGenerator::generate(), $this->hostnames);
        return $location;
    }
}