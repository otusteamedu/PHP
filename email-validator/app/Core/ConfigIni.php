<?php


namespace App\Core;


use App\Api\ConfigInterface;
use Exception;

class ConfigIni implements ConfigInterface
{
    private array $data = [];

    /**
     * @param string|array $fileName
     * @return ConfigIni
     * @throws Exception
     */
    public function loadFile($fileName): self
    {
        if (is_array($fileName)) {
            foreach ($fileName as $file) {
                return $this->loadFile($file);
            }
        }
        if (!is_file($fileName)) {
            throw new Exception('Config file is not found '.$fileName);
        }
        $this->data = array_merge_recursive($this->data, parse_ini_file($fileName, true));
        return $this;
    }

    /**
     * @param string $name
     * @param string|array|null $default
     * @param bool $noisy
     * @return string|array|null
     */
    public function get(string $name, $default = null, $noisy = false)
    {
        if (!$name) {
            return $default;
        }
        $keys = explode('.', $name);
        $value = $this->data;
        foreach ($keys as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                if ($noisy) {
                    throw new Exception('Config is not set '.$name);
                }
                return $default;
            }
        }
        return $value;
    }

    /**
     * @param string $name
     * @return array|string|null
     * @throws Exception
     */
    public function getOrFail(string $name)
    {
        return $this->get($name, null, true);
    }
}