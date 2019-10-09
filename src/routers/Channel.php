<?php
declare(strict_types = 1);

namespace Alex\Youtubestat\Routers;

class Channel
{
    private $method;
    private $urlData;
    private $formData;

    public function __construct($method, $urlData, $formData)
    {
        $this->method = $method;
        $this->urlData = $urlData;
        $this->formData = $formData;
    }

    public function route()
    {

        // Получение всей информации о пользователе
        // GET /users/{userId}
        if ($this->method === 'GET' && count($this->urlData) === 1) {
            // Получаем id товара
            $channelId = $this->urlData[0];

            $channel = $this->getChannel($channelId);

            echo json_encode($channel);

            return;
        }


        // Получение общей информации о пользователе
        // GET /users/{userId}/info
        if ($this->method === 'GET' && count($this->urlData) === 2 && $this->urlData[1] === 'info') {
            // Получаем id товара
            $channelId = $this->urlData[0];

            $channelInfo = $this->getChannelInfo($channelId);

            // Выводим ответ клиенту
            echo json_encode($channelInfo);

            return;
        }


        // Получение заказов пользователя
        // GET /users/{userId}/orders
        if ($this->method === 'GET' && count($this->urlData) === 2 && $this->urlData[1] === 'orders') {
            // Получаем id товара
            $channelId = $this->urlData[0];

            $channelVideos = $this->getChannelVideos($channelId);

            // Выводим ответ клиенту
            echo json_encode($channelVideos);

            return;
        }

        // Возвращаем ошибку
        header('HTTP/1.0 400 Bad Request');
        echo json_encode(array(
            'error' => 'Bad Request'
        ));

    }

    protected function getChannel($channelId)
    {

        // Вытаскиваем все данные о пользователе из базы...

        // Выводим ответ клиенту
        return array(
            'method' => 'GET',
            'id' => $channelId,
            'info' => array(
                'email' => 'webdevkin@gmail.com',
                'name' => 'Webdevkin'
            ),
            'orders' => array(
                array(
                    'orderId' => 5,
                    'summa' => 2000,
                    'orderDate' => '12.01.2017'
                ),
                array(
                    'orderId' => 8,
                    'summa' => 5000,
                    'orderDate' => '03.02.2017'
                )
            )
        );

    }

    protected function getChannelInfo($channelId)
    {
        // Вытаскиваем общие данные о пользователе из базы...

        return array(
            'method' => 'GET',
            'id' => $channelId,
            'info' => array(
                'email' => 'webdevkin@gmail.com',
                'name' => 'Webdevkin'
            )
        );
    }

    protected function getChannelVideos($channelId)
    {

        // Вытаскиваем данные о заказах пользователя из базы...

        return array(
            'method' => 'GET',
            'id' => $channelId,
            'orders' => array(
                array(
                    'orderId' => 5,
                    'summa' => 2000,
                    'orderDate' => '12.01.2017'
                ),
                array(
                    'orderId' => 8,
                    'summa' => 5000,
                    'orderDate' => '03.02.2017'
                )
            )
        );

    }

}
