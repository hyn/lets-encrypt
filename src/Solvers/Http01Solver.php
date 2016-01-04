<?php

namespace Hyn\LetsEncrypt\Solvers;

use Hyn\LetsEncrypt\Contracts\ChallengeSolverContract;
use Hyn\LetsEncrypt\Resources\Challenge;

/**
 * Class Http01Solver.
 *
 * @see https://letsencrypt.github.io/acme-spec/#simple-http
 *
 *      Provide a file at the specified location.
 *      The location is declared using the prefix:
 *      `.well-known/acme-challenge/` and concluded
 *      with the token value.
 *      Eg: yoursite.com/.well-known/acme-challenge/<token>
 */
class Http01Solver implements ChallengeSolverContract
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
