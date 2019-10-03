<?php
/**
 * Class helps to store all configuraton values
 *
 * @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
 */
namespace Jekys;

class Config extends Abstraction\Singleton
{
    /**
    * @var array
    */
    private $options = [];

    /**
     * Returns option value
     *
     * @throws \Exception
     *
     * @param $option
     *
     * @return mixed
     */
    public function __get(string $option)
    {
        if (array_key_exists($option, $this->options)) {
            return $this->options[$option];
        } else {
            throw new \Exception('Option "'.$option.'" doesn`t exists in the config object');
        }
    }

    /**
     * Sets option value
     *
     * @return void
     */
    public function __set(string $option, $value)
    {
        $this->options[$option] = $value;
    }
}
