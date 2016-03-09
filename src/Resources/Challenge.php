<?php

namespace Hyn\LetsEncrypt\Resources;

use Carbon\Carbon;
use Hyn\LetsEncrypt\Exceptions\UnsolvableChallengeException;
use Illuminate\Support\Arr;

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
        'Hyn\LetsEncrypt\Solvers',
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
        $this->hostname = $hostname;

        list($this->location, $response) = $result;

        $this->expires = Carbon::createFromFormat('Y-m-d?H:i:s.u', $this->fixZolo($response->expires), 'UTC');

        $this->status = $response->status;

        $this->parseChallenges($response->challenges, $response->combinations);
    }

    /**
     * Some weird formatting is occurring that Carbon and DateTime cannot parse.
     *
     * @param $expires
     *
     * @return string
     */
    protected function fixZolo($expires)
    {
        if (preg_match('/\.([0-9]+)([A-Z]+)$/', $expires, $m)) {
            $expires = substr($expires, 0, -(strlen($m[2]) + strlen($m[1]) - 6));
        }

        return $expires;
    }

    /**
     * Work through the challenges and solve them.
     *
     * @param array $challenges
     * @param array $combinations
     *
     * @return array
     */
    protected function parseChallenges($challenges = [], $combinations = [])
    {
        if (empty($challenges) || empty($combinations)) {
            return [];
        }

        // loop through all challenges to find suitable challenge solvers
        foreach ($challenges as $id => $challenge) {

            // check against combinations first
            if (! in_array([$id], $combinations)) {
                continue;
            }

            $type = ucfirst(str_replace([' ', '', '-'], null, $challenge->type));

            // look for a solver in the registered namespaces
            foreach (array_reverse(static::$solverLocations) as $namespace) {
                $solver = sprintf('%s\%sSolver', $namespace, $type);
                // a solver class has been found for this challenge type
                if (class_exists($solver)) {
                    $this->challenges[$id] = [
                        'payload' => $challenge,
                        'solver'  => $solver,
                    ];
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
     * @throws UnsolvableChallengeException
     *
     * @return bool
     */
    public function solve()
    {
        if (empty($this->challenges)) {
            throw new UnsolvableChallengeException("Missing challenge solver for {$this->hostname}");
        }

        foreach ($this->challenges as $id => $challenge) {
            $solver = Arr::get($challenge, 'solver');

            return (new $solver())->solve($this, Arr::get($challenge, 'payload', []));
        }
    }

    /**
     * @param mixed $hostname
     *
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

    /**
     * @return Certificate
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
}
