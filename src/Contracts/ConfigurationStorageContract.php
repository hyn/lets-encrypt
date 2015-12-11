<?php namespace Hyn\LetsEncrypt\Contracts;

interface ConfigurationStorageContract
{

    /**
     * Get a key from the configuration storage.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null);


    /**
     * Sets the value of a key in the configuration storage.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value);
}