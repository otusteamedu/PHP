<?php


namespace App;


/**
 * Class HttpRequestOrderTemplate
 * @package App
 */
abstract class HttpRequestOrderTemplate
{
    /**
     * @var
     */
    public $factory;
    /**
     * @var
     */
    public $Order;
    /**
     * @var
     */
    public $Type ;
    /**
     * @var
     */
    public $Client;
    /**
     * @var
     */
    public $Coupon ;
    /**
     * @var
     */
    public $DeliverService;
    /**
     * @var
     */
    public $Product;
    /**
     * @var
     */
    public $DiscountDeliveryService;
    /**
     * @var
     */
    public $Parser;

    /**
     * @var
     */
    public $idType;
    /**
     * @var
     */
    public $idClient;
    /**
     * @var
     */
    public $idCoupon ;
    /**
     * @var
     */
    public $idDeliverService ;
    /**
     * @var
     */
    public $discountCouponCoefficient;
    /**
     * @var
     */
    public $discountCouponRub ;
    /**
     * @var array
     */
    public $priceProducts=[];
    /**
     * @var
     */
    public $priceDeliverService;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $InsertOrder;
    /**
     * @var
     */
    public $price;
    /**
     * @var
     */
    public $postPoducts;
    /**
     * @var
     */
    public $OrderProduct;
    /**
     * @var
     */
    public $orderId;

    /**
     * @param $post
     * @param $name
     */
    final public function request($post, $name)
    {
    $this->requestContext();
    $this->requestPreCreate();
    $this->requestCreate($post,$name);
    $this->requestPreInsert();
    $this->requestInsertOrder();
    $this->requestInsertOrderProduct();
    $this->requestInsertParser($post['products']);

    }

    /**
     * @return mixed
     */
    abstract public function requestContext();

    /**
     * @param $post
     * @param $name
     * @return mixed
     */
    abstract public function  requestCreate($post, $name);

    /**
     * @return mixed
     */
    abstract public  function  requestInsertOrder();

    /**
     * @return mixed
     */
    abstract public  function  requestInsertOrderProduct();

    /**
     * @param $products
     * @return mixed
     */
    abstract public function requestInsertParser($products);

    /**
     *
     */
    public function requestPreCreate()
    {
        $this->OrderProduct=$this->factory->create('OrderProduct');
        $this->Order = $this->factory->create('Order');
        $this->Type = $this->factory->create('Type');
        $this->Client = $this->factory->create('Client');
        $this->Coupon = $this->factory->create('Coupon');
        $this->DeliverService = $this->factory->create('DeliverService');
        $this->Product = $this->factory->create('Product');
        $this->DiscountDeliveryService=$this->factory->create('DiscountDeliveryService');
        $this->Parser=$this->factory->create('Parser');
    }


    /**
     *
     */
    public function requestPreInsert()
    {
       $fullPrice = ($this->factory->create('FullPriceBuilder'))
            ->addDiscountCouponCoefficient($this->discountCouponCoefficient)
            ->addDiscountCouponRub($this->discountCouponRub)
            ->addProductPrice($this->priceProducts)
            ->addDeliveryPrice($this->priceDeliverService)
            ->countPrice()
            ->build();

       $this->price = $fullPrice->orderPrice;




    }



}