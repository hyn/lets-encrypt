<?php namespace Hyn\LetsEncrypt\Storages\Configuration;

use Hyn\LetsEncrypt\Contracts\ConfigurationStorageContract;

class DiskStorage implements ConfigurationStorageContract
{
    /**
     * Directory to store configuration under.
     *
     * @var string
     */
    protected $path;

    /**
     * DiskStorage constructor.
     *
     * @param $path
     */
    public function __construct($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $this->path = $path;
    }

    /**
     * Get a key from the configuration storage.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (file_exists($this->getKeyPath($key))) {
            return file_get_contents($this->getKeyPath($key));
        }

        return $default;
    }

    /**
     * Sets the value of a key in the configuration storage.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        file_put_contents($this->getKeyPath($key), $value);
    }

    /**
     * @param $key
     * @return string
     */
    protected function getKeyPath($key)
    {
        return sprintf("%s/%s", $this->path, $key);
    }

    /**
     * Resets a value in the storage.
     *
     * @param $key
     * @return mixed
     */
    public function reset($key)
    {
        @unlink($this->getKeyPath($key));
    }
}