<?php namespace Hyn\LetsEncrypt\Resources;

use Carbon\Carbon;
use Hyn\LetsEncrypt\Exceptions\UnsolvableChallengeException;

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
     * @var Certificate
     */
    protected $certificate;

    /**
     * @var array
     */
    protected static $solverLocations = [
        'Hyn\LetsEncrypt\Solvers'
    ];

    /**
     * Challenge constructor.
     *
     * @param Certificate $certificate
     * @param string      $hostname
     * @param array       $result
     */
    public function __construct(Certificate $certificate, $hostname, $result)
    {
        $this->certificate = $certificate;
        $this->hostname    = $hostname;
        list($this->location, $response) = $result;

        $this->expires = new Carbon($response->expires);
        $this->status  = $response->status;
        $this->parseChallenges($response->challenges, $response->combinations);
    }

    protected function parseChallenges($challenges = [], $combinations = [])
    {
        if (empty($challenges) || empty($combinations)) {
            return [];
        }

        // loop through all challenges to find suitable challenge solvers
        foreach ($challenges as $id => $challenge) {

            // check against combinations first
            if(!in_array([$id], $combinations))
            {
                continue;
            }

            $type   = ucfirst(str_replace([' ', '', '-'], null, $challenge->type));

            // look for a solver in the registered namespaces
            foreach(array_reverse(static::$solverLocations) as $namespace)
            {
                $solver = sprintf('%s\%s', $namespace, $type);

                // a solver class has been found for this challenge type
                if(class_exists($solver))
                {
                    $this->challenges[$id] = $solver;
                    break;
                }
            }
        }
    }

    /**
     * Attempt to solve the challenge.
     *
     * The sequence can be influenced by setting the $solverLocations manually.
     *
     * @return boolean
     * @throws UnsolvableChallengeException
     */
    public function solve()
    {
        if(empty($this->challenges))
        {
            throw new UnsolvableChallengeException("Missing challenge solver for {$this->hostname}");
        }

        foreach($this->challenges as $id => $solver)
        {
            return (new $solver)->solve($this);
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

    /**
     * Adds another namespace to find solvers in.
     *
     * @param string $namespace
     */
    public static function addSolverLocation($namespace)
    {
        static::$solverLocations[] = $namespace;
    }

    /**
     * Forces the search for suitable challenge solvers in the provided namespaces.
     *
     * @param array $namespaces
     */
    public static function setSolverLocations($namespaces = [])
    {
        static::$solverLocations = $namespaces;
    }

    /**
     * Provides the list of solver namespaces to search in.
     *
     * @return array
     */
    public static function getSolverLocations()
    {
        return static::$solverLocations;
    }
}