<?php

namespace Tests\_support\Model;

class SearchRowModel extends JsonDataDriver implements ModelInterface
{
    /* Артикул  */
    public $article;
    /* Производитель */
    public $brand;
    /* Наименование */
    public $name;
    /* Цена */
    public $price;
    /* Сумма */
    public $sum;
    /* Наличие, количество */
    public $remains;
    /* Направление  */
    public $destination;
    /* Оценка наличия  */
    public $evaluationRemains;
    /* Оценка доставки / Рейтинг - в новом поиске */
    public $evaluationDelivery;
    /* Срок доставки средний  */
    public $termAvg;
    /* Срок доставки максимальный */
    public $termMax;
    /* Изображение */
    public $photo;
    /* Поставщик */
    public $provider;
    /* Цена поставщика */
    public $providerPrice;
    /* Для API */
    public $clientId;

    protected $jsonFileName = 'search_row_data.json';

    /**
     * @param string $article
     * @return SearchRowModel
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * @param string $brand
     *
     * @return SearchRowModel
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Устанавливает цену в виде строки с 2 знаками после запятой.
     *
     * @param string $price
     *
     * @return SearchRowModel
     */
    public function setPrice($price)
    {
        $this->price = number_format($price, 2, '.', '');

        return $this;
    }

    /**
     * @param int $remains
     *
     * @return SearchRowModel
     */
    public function setRemains($remains)
    {
        $this->remains = $remains;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return SearchRowModel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $destination
     *
     * @return SearchRowModel
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * @param int $evaluationRemains
     *
     * @return SearchRowModel
     */
    public function setEvaluationRemains($evaluationRemains)
    {
        $this->evaluationRemains = $evaluationRemains;

        return $this;
    }

    /**
     * @param $evaluationDelivery
     * @return $this
     */
    public function setEvaluationDelivery($evaluationDelivery)
    {
        $this->evaluationDelivery = $evaluationDelivery;

        return $this;
    }

    /**
     * @param int $termAvg
     *
     * @return SearchRowModel
     */
    public function setTermAvg($termAvg)
    {
        $this->termAvg = $termAvg;

        return $this;
    }

    /**
     * @param int $termMax
     *
     * @return SearchRowModel
     */
    public function setTermMax($termMax)
    {
        $this->termMax = $termMax;

        return $this;
    }

    /**
     * @param string $photo
     *
     * @return SearchRowModel
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @param string $provider
     *
     * @return SearchRowModel
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * @param float $providerPrice
     *
     * @return SearchRowModel
     */
    public function setProviderPrice($providerPrice)
    {
        $this->providerPrice = $providerPrice;

        return $this;
    }

    /**
     * @param string $sum
     *
     * @return SearchRowModel
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return number_format($this->price, 2, '.', '');
    }

    /**
     * Возвращает цену с 4 знаками после запятой.
     * Только для страницы проценки
     *
     * @return string
     */
    public function getSearchPrice()
    {
        return number_format($this->price, 4, '.', '');
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     * @return SearchRowModel
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @return string
     */
    public function getRemains()
    {
        return $this->remains;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return string
     */
    public function getEvaluationRemains()
    {
        return $this->evaluationRemains;
    }

    /**
     * @return string
     */
    public function getEvaluationDelivery()
    {
        return $this->evaluationDelivery;
    }

    /**
     * @return string
     */
    public function getTermAvg()
    {
        return $this->termAvg;
    }

    /**
     * @return string
     */
    public function getTermMax()
    {
        return $this->termMax;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getProviderPrice()
    {
        return $this->providerPrice;
    }
}
