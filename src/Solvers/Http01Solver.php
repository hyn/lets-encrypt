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
     * Path to store the challenge file.
     *
     * @var string
     */
    protected static $challenge_public_path;
    /**
     * @var Challenge
     */
    protected $challenge;

    /**
     * @var \stdClass
     */
    protected $payload;

    /**
     * Unique token for the certificate request.
     *
     * @var string
     */
    protected $token;

    /**
     * Sets the publicly available directory to store challenge files into.
     *
     * @param string $challenge_public_path
     *
     * @throws \Exception
     */
    public static function setChallengePublicPath($challenge_public_path)
    {
        if (is_dir($challenge_public_path)) {
            self::$challenge_public_path = rtrim($challenge_public_path, '/');
        } else {
            throw new \Exception('Directory to write challenge files into, must exist.');
        }
    }

    /**
     * Solves a certain challenge.
     *
     * Return false if not possible.
     *
     * @param Challenge $challenge
     * @param \stdClass $payload
     *
     * @return bool
     */
    public function solve(Challenge $challenge, $payload)
    {
        $this->challenge = $challenge;
        $this->payload = $payload;
        $this->token = $payload->token;

        $httpFeedback = $this->acme()->generateHttp01Payload($this->token);

        if (file_put_contents(static::$challenge_public_path.'/'.$this->token, $httpFeedback) === false) {
            return false;
        }

        $this->acme()->selfVerify($challenge->getHostname(), $this->token, $httpFeedback);
        $this->acme()->answerChallenge($payload->uri, $httpFeedback);

        $this->acme()->pollForChallenge($challenge->getLocation());

        unlink(static::$challenge_public_path.'/'.$this->token);

        return true;
    }

    /**
     * @return \Hyn\LetsEncrypt\Acme\Client
     */
    protected function acme()
    {
        return $this->challenge->getCertificate()->getAccount()->acme();
    }
}
