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

        if(!$this->config("{$this->username}.key-pair"))
        {
            $this->acme()->register($this->emailAddress);
            $this->getConfigurationStorage()->set("{$this->username}.key-pair", $this->acme()->getKeyPair());
        }
    }

    /**
     * Register the account on the Acme server.
     */
    protected function register()
    {
        if($this->config("{$this->username}.key-pair"))
        {
            $this->acme()->setKeyPair($this->config("{$this->username}.key-pair"));
        }

        $result = $this->acme()->register($this->emailAddress);

        $this->getConfigurationStorage()->set("{$this->username}.key-pair", $this->acme()->getKeyPair());

        return $result;
    }
}