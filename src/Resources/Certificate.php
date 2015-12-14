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
     * @todo add challenges: https://github.com/Petertjuh360/da-letsencrypt/blob/master/user/actions/request.html#L59
     * @return mixed
     */
    public function request()
    {
        $challenges = $this->challenge();

        $location = $this->account->acme()->requestCertificate(KeyPairGenerator::generate(), $this->hostnames);
        $certificates = $this->account->acme()->pollForCertificate($location);
        return $certificates;
    }

    protected function challenge()
    {
        $locations = [];

        /** @var string $hostname */
        foreach($this->hostnames as $hostname)
        {
            list($locations[$hostname], $response) = $this->account->acme()->requestChallenges($hostname);

            var_dump($locations);
            var_dump($response);
        }
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }
}