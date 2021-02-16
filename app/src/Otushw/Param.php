<?php


namespace Otushw;

use Exception;
use Otushw\Exception\AppException;

/**
 * Class Param
 *
 * @package Otushw
 */
class Param
{
    const ALLOWED_SERVER = 'cli';

    const ALLOWED_TYPE = ['server', 'client'];

    /**
     * @var string
     */
    private string $typeApp;

    /**
     * Params constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->validate();
        $typeApp = $this->getRawParm();
        $this->setParam($typeApp);
    }

    /**
     * @throws Exception
     */
    private function validate(): void
    {
        if (php_sapi_name() != self::ALLOWED_SERVER) {
            throw new AppException('Allowed interface type: ' . self::ALLOWED_SERVER);
        }
        if (!isset($_SERVER['argv'][1])) {
            throw new AppException('To run the script, need the parameter.');
        }
        if (empty($_SERVER['argv'][1])) {
            throw new AppException('Parameter is empty.');
        }
        if (!in_array($_SERVER['argv'][1], self::ALLOWED_TYPE)) {
            throw new AppException('Invalid parameter value. Allowed "server" or "client"');
        }
    }

    /**
     * @return string
     */
    private function getRawParm(): string
    {
        return $_SERVER['argv'][1];
    }

    /**
     * @param string $typeApp
     */
    public function setParam(string $typeApp): void
    {
        $this->typeApp = $typeApp;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getParam(): string
    {
        if (empty($this->typeApp)) {
            throw new AppException('Parameter was not set.');
        }
        return $this->typeApp;
    }

}