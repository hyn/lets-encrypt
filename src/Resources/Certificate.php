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
     * @var array
     */
    protected $challenges = [];

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
        $challenges = $this->challenge();

        $location     = $this->account->acme()->requestCertificate(KeyPairGenerator::generate(), $this->hostnames);
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
}