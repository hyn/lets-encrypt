<?php namespace Hyn\LetsEncrypt\Contracts;

use Hyn\LetsEncrypt\Resources\Challenge;

interface ChallengeSolverContract {
    /**
     * Solves a certain challenge.
     *
     * Return false if not possible.
     *
     * @param Challenge $challenge
     * @return bool
     */
    public function solve(Challenge $challenge);
}