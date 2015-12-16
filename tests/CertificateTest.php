<?php

namespace Hyn\LetsEncrypt\Tests;

use Hyn\LetsEncrypt\Resources\Account;
use Hyn\LetsEncrypt\Resources\Certificate;

class CertificateTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $account = new Account('hyn-test', 'hyn-test@hyn.me');
        $certificate = new Certificate($account);
        $certificate->addHostname('test.hyn.me');
        var_dump($certificate->request());
    }
}
