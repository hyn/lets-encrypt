<?php namespace Hyn\LetsEncrypt\Tests;

use Hyn\LetsEncrypt\Resources\Account;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $account = new Account('hyn-test', 'hyn-test@hyn.me');

        var_dump($account->register());
    }
}