<?php namespace Hyn\LetsEncrypt\Tests;

use Hyn\LetsEncrypt\Resources\Certificate;
use Hyn\LetsEncrypt\Resources\Account;

class CertificateTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $account = new Account('hyn-test', 'hyn-test@hyn.me');
var_dump($account);
//        $certificate = new Certificate($account);
//        $certificate->addHostname('test.hyn.me');
//        var_dump($certificate->request());
    }
}