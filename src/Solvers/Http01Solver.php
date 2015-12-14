<?php namespace Hyn\LetsEncrypt\Solvers;

use Hyn\LetsEncrypt\Contracts\ChallengeSolverContract;

/**
 * Class Http01Solver
 *
 * @see https://letsencrypt.github.io/acme-spec/#simple-http
 *
 *      Provide a file at the specified location.
 *      The location is declared using the prefix:
 *      `.well-known/acme-challenge/` and concluded
 *      with the token value.
 *      Eg: yoursite.com/.well-known/acme-challenge/evaGxfADs6pSRb2LAv9IZf17Dt3juxGJ-PCt92wr-oA
 *
 * @package Hyn\LetsEncrypt\Solvers
 */
class Http01Solver implements ChallengeSolverContract
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