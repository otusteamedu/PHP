<?php
/**
* Tests for Config class
*
* @coversDefaultClass \Jekys\Config
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*
*/

use PHPUnit\Framework\TestCase;
use Jekys\Config;

final class ConfigTest extends TestCase
{
    /**
     * Config is a Singelton class
     * Shoudn't be called as new object
     *
     * @covers ::__construct
     *
     * @return void
     */
    public function testSingleton(): void
    {
        $this->expectException(\Error::class);
        $config = new Config();
    }

    /**
     * Method getInstance should returns the same object every time
     *
     * @covers ::getInstance()
     *
     * @return void
     */
    public function testGetInstance(): void
    {
        $config1 = Config::getInstance();
        $config2 = Config::getInstance();

        $this->assertEquals($config1, $config2);
    }

    /**
     * Getter should return the same value that it was setted
     *
     * @covers ::_set
     *
     * @return void
     */
    public function testSetGet(): void
    {
        $value = 'blabla';

        $config = Config::getInstance();

        $config->test = $value;

        $this->assertEquals($value, $config->test);
    }

    /**
     * Should get exception then trying to get unknown config option
     *
     * @covers ::_get
     *
     * @return void
     */
    public function testGetException(): void
    {
        $this->expectException(\Exception::class);

        $config = Config::getInstance();
        $config->unknown;
    }
}
