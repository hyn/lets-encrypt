<?php namespace Hyn\LetsEncrypt\Solvers;

use Hyn\LetsEncrypt\Contracts\ChallengeSolverContract;

/**
 * Class Dns01Solver
 *
 * @see https://letsencrypt.github.io/acme-spec/#dns
 *
 *      Add a TXT DNS record to the specified domain
 *      to validate ownership. The DNS label name
 *      should be _acme-challenge.
 *      Eg: _acme-challenge.example.com. 300 IN TXT "<token>"
 *
 * @package Hyn\LetsEncrypt\Solvers
 */
class Dns01Solver implements ChallengeSolverContract
{

    /**
     * Solves a certain challenge.
     *
     * Return false if not possible.
     *
     * @return bool
     */
    public function solve()
    {
        // TODO: Implement solve() method.
    }
}