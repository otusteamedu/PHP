<?php

namespace Tests\_support\Model;

class ProviderOrderPositionModel extends JsonDataDriver implements ModelInterface
{
    /* состояние */
    public $state;
    /* поставщик */
    public $provider;
    /* заказ клиента */
    public $clientOrder;
    /* заказ поставщику */
    public $providerOrder;
    /* артикул */
    public $article;
    /* наименование */
    public $name;
    /* производитель */
    public $brand;

    protected $jsonFileName = 'provider_order_position_data.json';

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return mixed
     */
    public function getClientOrder()
    {
        return $this->clientOrder;
    }

    /**
     * @param mixed $clientOrder
     */
    public function setClientOrder($clientOrder)
    {
        $this->clientOrder = $clientOrder;
    }

    /**
     * @return mixed
     */
    public function getProviderOrder()
    {
        return $this->providerOrder;
    }

    /**
     * @param mixed $providerOrder
     */
    public function setProviderOrder($providerOrder)
    {
        $this->providerOrder = $providerOrder;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }


}