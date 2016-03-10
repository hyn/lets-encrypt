<?php

namespace Hyn\LetsEncrypt\Resources;

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
     * @var array
     */
    protected $challenges = [];

    /**
     * @var Account
     */
    protected $account;

    /**
     * A custom identifier to use in your applications.
     *
     * @var mixed
     */
    protected $identifier;

    /**
     * The certificate key.
     *
     * @var string
     */
    protected $key;

    /**
     * The certificate.
     *
     * @var string
     */
    protected $certificate;


    /**
     * The certificate bundle.
     *
     * @var string
     */
    protected $bundle;

    /**
     * Certificate constructor.
     *
     * @param Account $account
     * @param null    $identifier A custom identifier to use in your applications.
     */
    public function __construct(Account $account, $identifier = null)
    {
        $this->account = $account;
        $this->identifier = $identifier;
    }

    /**
     * Add a hostname for a certificate request.
     *
     * @param $hostname
     *
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
        $challenges = $this->challenge();

        $location = $this->account->acme()->requestCertificate($this->getKey(), $this->hostnames);
        $certificates = $this->account->acme()->pollForCertificate($location);

        return $certificates;
    }

    /**
     * @return array
     */
    protected function challenge()
    {
        /** @var string $hostname */
        foreach ($this->hostnames as $hostname) {
            $this->challenges[$hostname] = (new Challenge($this, $hostname,
                $this->account->acme()->requestChallenges($hostname)))
                ->solve();
        }

        return $this->challenges;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param mixed $identifier
     *
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        if (!$this->key) {
            $this->key = KeyPairGenerator::generate();
        }

        return $this->key;
    }

    /**
     * @param string $certificate
     * @return Certificate
     */
    public function setCertificate($certificate)
    {
        $this->certificate = trim($certificate);

        return $this;
    }

    /**
     * @return string
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * @param string $bundle
     * @return Certificate
     */
    public function setBundle($bundle)
    {
        $this->bundle = trim($bundle);

        return $this;
    }

    /**
     * @return string
     */
    public function getBundle()
    {
        return $this->bundle;
    }
}
