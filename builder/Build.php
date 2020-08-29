<?php

namespace \Builder;

class Build {
    private $client;
    private $products = [];
    private $services = [];

    public function __construct(object $client, array $products = [], array $services = []) 
    {
        $this->client = $client ?? null;
        $this->products = $products ?? null;
        $this->Services = $services ?? null;
    }


    
    // здесь будут несколько приватных методов которые собирают конечный результат
    


    public function getResult() : Array
    {
        // в итоге тут возращаем собранный результат клиент, продукты и услуги
        // возращает массив в виде токого формата

        /* [
            'client' => [
                // тут все данные о клиенте
            ],
            'products' => [
                // тут все данные о продуктах которые были введенны в массив
            ],
            'services' => [
                // тут все данные о сервисах которые были введены в массив
            ]
        ] */
    }
}
