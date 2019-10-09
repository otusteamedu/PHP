<?php
use Alex\Youtubestat\Helpers;
use Alex\Youtubestat\Routers\Video;

try {

    require_once 'vendor/autoload.php';

    $helper = new Helpers();

    // Определяем метод запроса
    $method = $_SERVER['REQUEST_METHOD'];

    // Получаем данные из тела запроса
    $formData = $helper->getFormData($method);


    // Разбираем url
    $url = isset($_GET['q']) ? $_GET['q'] : '';
    $url = rtrim($url, '/');
    $urls = explode('/', $url);

    // Определяем роутер и url data
    $router = $urls[0];
    $urlData = array_slice($urls, 1);

    $className = 'Alex\\Youtubestat\\Routers\\' . ucfirst(strtolower(trim($router)));

    $router = new $className($method, $urlData, $formData);
    $router->route();

    $redis = new Redis();

} catch (Exception $e) {

    echo 'Catchable error occured: ' . $e->getMessage() . ' in file: ' . $e->getFile() . ' on line: ' . $e->getLine();

}
