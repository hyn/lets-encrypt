<?php namespace Hyn\LetsEncrypt\Resources;

/**
 * Class Account
 *
 * @package Hyn\LetsEncrypt\Resources
 */
class Account
{
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

    }
}