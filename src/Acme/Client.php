<?php namespace Hyn\LetsEncrypt\Acme;

use Crypt_RSA;
use Hyn\LetsEncrypt\Helpers\KeyPairGenerator;
use Kelunik\Acme\AcmeClient;
use Kelunik\Acme\AcmeService;
use Kelunik\Acme\KeyPair;

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
     * @var KeyPair
     */
    protected $keyPair;

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
        if (!$this->getKeyPair()) {
            $this->setKeyPair(KeyPairGenerator::generate());
        }
        if (!$this->acmeClient) {
            $this->acmeClient = new AcmeClient($this->getDictionaryEndpoint(), $this->getKeyPair());
        }
        if (!$this->acmeService) {
            $this->acmeService = new AcmeService($this->acmeClient, $this->getKeyPair());
        }

        return $this;
    }

    /**
     * Pass through for Acme service.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    function __call($name, $arguments)
    {
        $this->setup();

        return call_user_func_array([$this->acmeService, $name], $arguments);
    }

    /**
     * @param KeyPair $keyPair
     * @return Client
     */
    public function setKeyPair($keyPair)
    {
        $this->keyPair = $keyPair;

        return $this;
    }

    /**
     * @return KeyPair
     */
    public function getKeyPair()
    {
        return $this->keyPair;
    }
}