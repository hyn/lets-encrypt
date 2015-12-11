<?php namespace Hyn\LetsEncrypt\Acme;

use Kelunik\Acme\AcmeClient;
use Kelunik\Acme\AcmeService;

/**
 * Class Client
 *
 * @package Hyn\LetsEncrypt\Acme
 */
class Client
{
    /**
     * Let's Encrypt Acme directory endpoint.
     *
     * @var string
     */
    protected $dictionaryEndpoint = 'https://acme-staging.api.letsencrypt.org/directory';
    /**
     * @var AcmeClient
     */
    protected $acmeClient;

    /**
     * @var AcmeService
     */
    protected $acmeService;

    /**
     * Client constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param AcmeClient $acmeClient
     * @return Client
     */
    public function setAcmeClient($acmeClient)
    {
        $this->acmeClient = $acmeClient;

        return $this;
    }

    /**
     * @param AcmeService $acmeService
     * @return Client
     */
    public function setAcmeService($acmeService)
    {
        $this->acmeService = $acmeService;

        return $this;
    }

    /**
     * @param string $dictionaryEndpoint
     * @return Client
     */
    public function setDictionaryEndpoint($dictionaryEndpoint)
    {
        $this->dictionaryEndpoint = $dictionaryEndpoint;

        return $this;
    }

    /**
     * @return string
     */
    public function getDictionaryEndpoint()
    {
        return $this->dictionaryEndpoint;
    }

    /**
     * Instantiates Acme Service object.
     *
     * @return Client
     */
    protected function setup()
    {
        if (!$this->acmeClient) {
            $this->acmeClient = new AcmeClient($this->getDictionaryEndpoint());
        }
        if (!$this->acmeService) {
            $this->acmeService = new AcmeService($this->acmeClient);
        }

        return $this;
    }
}