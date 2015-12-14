<?php namespace Hyn\LetsEncrypt\Resources;

use Carbon\Carbon;

class Challenge
{

    /**
     * @var string
     */
    protected $hostname;

    /**
     * @var Carbon
     */
    protected $expires;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var array
     */
    protected $challenges = [];

    /**
     * Challenge constructor.
     *
     * @param string $hostname
     * @param array  $result
     */
    public function __construct($hostname, $result)
    {
        $this->hostname = $hostname;
        list($this->location, $response) = $result;

        $this->expires    = new Carbon($response->expires);
        $this->status     = $response->status;
        $this->challenges = $this->parseChallenges($response->challenges);
    }

    protected function parseChallenges($challenges = [])
    {
        foreach($challenges as $id => $challenge)
        {

        }
    }

    /**
     * @param mixed $hostname
     * @return Challenge
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @return Carbon
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getChallenges()
    {
        return $this->challenges;
    }
}