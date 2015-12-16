<?php

namespace Hyn\LetsEncrypt\Tests;

use Hyn\LetsEncrypt\Resources\Challenge;

class SolversTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultSolversExist()
    {
        $this->assertTrue(in_array('Hyn\LetsEncrypt\Solvers', Challenge::getSolverLocations()));
    }
}
