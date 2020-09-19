<?php

namespace Handlers;

use Controllers\MainController;

class MainViewHandler
{
    public static function displayData(MainController $mainController)
    {
        $resultArr = $mainController->getSaveYoutubeData()['hits']['hits'];
        foreach ($resultArr as $result) {
            echo '<hr>';
            echo 'название канала - ' . $result['_id'] . '<br>';
            echo 'всего видео - ' . $result['_source']['countVideo'] . '<br>';
            echo 'общее число просмотров - ' . $result['_source']['views'] . '<br>';
            echo 'в среднем просмотров - ' . ((int)$result['_source']['views'] / (int)$result['_source']['countVideo']);
            echo '<br><hr>';
        }
    }

    public static function validateInputData($dirtyName)
    {
        $name = htmlspecialchars($dirtyName);
        if (iconv_strlen($name) > 150) {
            echo 'Максимальное число символов имени канала 150 символов';
            return false;
        }
        return $name;
    }
}
