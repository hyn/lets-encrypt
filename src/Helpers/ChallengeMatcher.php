<?php namespace Hyn\LetsEncrypt\Helpers;

use Hyn\LetsEncrypt\Resources\Certificate;
use Hyn\LetsEncrypt\Resources\Challenge;

class ChallengeMatcher {

    /**
     * @var Certificate
     */
    protected $certificate;

    /**
     * @var array
     */
    protected $challenges;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function match()
    {
        foreach($this->certificate->getHostnames() as $hostname)
        {
            $challenges[$hostname] = new Challenge($hostname, $this->certificate->getAccount()->acme()->requestChallenges($hostname));
        }
    }
}