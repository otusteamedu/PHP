<?php

namespace Tests\_support\Model;

/**
 * Class BaseModel
 * @package Tests\_support\Model
 */
class BaseModel
{
    /** Имя JSON файла (с расширением) */
    protected $jsonFileName = '';
    /** Данные из файла JSON */
    protected $jsonData;

    public function __construct()
    {
        $this->jsonData = $this->getJsonData($this->jsonFileName);
    }

    /**
     * Берет данные из JSON файла.
     * @param string $jsonFileName - имя JSON файла (с расширением)
     * @return array
     */
    public function getJsonData($jsonFileName)
    {
        if (empty($jsonFileName)) {
            return [];
        }

        $projectDataPath = codecept_data_dir() . '/' . $jsonFileName;

        if (is_file($projectDataPath)) {
            return json_decode(file_get_contents($projectDataPath), true);
        }

        return [];
    }

    /**
     * Инициализируем переменные класса данными из массива $arData.
     * Ключи массива должны сооветствовать именам переменных класса, который вызывает функцию
     * @param array $arData - массив данных, полученных из JSON файла
     */
    public function init(array $arData)
    {
        foreach ($arData as $field => $value) {
            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
        $arrProperty = get_object_vars($this);
        foreach ($arrProperty as $property => $value) {
            if ($this->$property === null) {
                $this->$property = false;
            }
        }
    }

    /**
     * Установить свойства модели из данных определенного блока json файла
     * @param string $jsonBlockName - наименование блока данных в json файле
     */
    public function setModel($jsonBlockName)
    {
        $this->init($this->jsonData[$jsonBlockName]);
    }

    public function setModelForTest($cestClass, $jsonBlockName)
    {
        $this->init($this->jsonData[$cestClass][$jsonBlockName]);
    }
}