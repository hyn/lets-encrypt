<?php

namespace Hyn\LetsEncrypt\Solvers;

use Hyn\LetsEncrypt\Contracts\ChallengeSolverContract;
use Hyn\LetsEncrypt\Resources\Challenge;

/**
 * Class Dns01Solver.
 *
 * @see https://letsencrypt.github.io/acme-spec/#dns
 *
 *      Add a TXT DNS record to the specified domain
 *      to validate ownership. The DNS label name
 *      should be _acme-challenge.
 *      Eg: _acme-challenge.example.com. 300 IN TXT "<token>"
 */
class Dns01Solver implements ChallengeSolverContract
{
    /**
     * Solves a certain challenge.
     *
     * Return false if not possible.
     *
     * @param Challenge $challenge
     * @param array     $payload
     *
     * @return bool
     */
    public function solve(Challenge $challenge, $payload = [])
    {
        // TODO: Implement solve() method.
    }
}
