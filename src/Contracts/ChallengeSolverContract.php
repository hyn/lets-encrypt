<?php namespace Hyn\LetsEncrypt\Contracts;

interface ChallengeSolverContract {
    /**
     * Solves a certain challenge.
     *
     * Return false if not possible.
     *
     * @return bool
     */
    public function solve();
}