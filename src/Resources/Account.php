<?php namespace Hyn\LetsEncrypt\Resources;

use Hyn\LetsEncrypt\Acme\AcmeCallable;
use Hyn\LetsEncrypt\Helpers\Configured;

/**
 * Class Account
 *
 * @package Hyn\LetsEncrypt\Resources
 */
class Account
{
    use AcmeCallable;
    use Configured;
    /**
     * Username of the account.
     *
     * @var string
     */
    protected $username;

    /**
     * EmailAddress of the account.
     *
     * @var string
     */
    protected $emailAddress;

    /**
     * Account constructor.
     *
     * @param $username
     * @param $emailAddress
     */
    public function __construct($username, $emailAddress)
    {
        $this->username     = $username;
        $this->emailAddress = $emailAddress;
    }

    /**
     * Register the account on the Acme server.
     */
    public function register()
    {
        $acme = $this->acme();

        if($this->config("{$this->username}.key-pair"))
        {
            $acme->setKeyPair($this->config("{$this->username}.key-pair"));
        }

        $result = $acme->register($this->emailAddress);

        $this->getConfigurationStorage()->set("{$this->username}.key-pair", $acme->getKeyPair());

        return $result;
    }
}