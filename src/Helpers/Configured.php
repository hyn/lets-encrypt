<?php

namespace Hyn\LetsEncrypt\Helpers;

use Hyn\LetsEncrypt\Contracts\ConfigurationStorageContract;
use Hyn\LetsEncrypt\Storages\Configuration\DiskStorage;

trait Configured
{
    /**
     * @var ConfigurationStorageContract
     */
    protected $configurationStorage;

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return $this->getConfigurationStorage()->get($key, $default);
    }

    /**
     * @return mixed
     */
    public function getConfigurationStorage()
    {
        if (empty($this->configurationStorage)) {
            $this->setConfigurationStorage(new DiskStorage('/tmp/hyn-lets-encrypt'));
        }

        return $this->configurationStorage;
    }

    /**
     * @param mixed $configurationStorage
     */
    public function setConfigurationStorage(ConfigurationStorageContract $configurationStorage)
    {
        $this->configurationStorage = $configurationStorage;
    }
}
