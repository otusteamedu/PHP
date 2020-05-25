<?php
namespace HW4\Config;

class Config
{
    private string $filePath;
    private array $configData;

    /**
     * Config constructor.
     *
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @param string $name
     * @param string|null $sections
     *
     * @return mixed
     * @throws ConfigException
     */
    public function get(string $name, ?string $sections = null)
    {
        if (empty($this->configData)) {
            $this->init();
        }

        if (!empty($sections) && !empty($this->configData[$sections])) {
            return $this->configData[$sections][$name] ?? '';
        }

        return $this->configData[$name] ?? '';
    }

    /**
     * @throws ConfigException
     */
    private function init(): void
    {
        if (!file_exists($this->filePath)) {
            throw new ConfigException();
        }

        $this->configData = parse_ini_file(
            $this->filePath,
            true
        );
    }
}