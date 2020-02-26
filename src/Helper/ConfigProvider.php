<?php

namespace Sergey\Otus\Helper;

class ConfigProvider
{
    private static $instance;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @return \Sergey\Otus\Helper\ConfigProvider
     * @throws \Exception
     */
    public static function getInstance($basePath = null)
    {
        if (!self::$instance) {
            self::$instance = new self($basePath);
        }

        return self::$instance;
    }

    private function __construct($basePath)
    {
        $this->setBasePath($basePath);
        $this->config = parse_ini_file($this->getBasePath() . '/etc/config.ini');

        if (!$this->config) {
            throw new \Exception('Invalid config file.');
        }
    }

    /**
     * @return string|null
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return string
     */
    public function getClientSocketFile()
    {
        return $this->getBasePath() . '/' . $this->config['client_socket'];
    }

    /**
     * @return string
     */
    public function getServerSocketFile()
    {
        return $this->getBasePath() . '/' . $this->config['server_socket'];
    }

    /**
     * @param string $dir
     */
    private function setBasePath($dir)
    {
        $this->basePath = $dir;
    }
}