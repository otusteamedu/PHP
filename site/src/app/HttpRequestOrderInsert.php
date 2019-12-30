<?php


namespace App;
use App\HttpRequestOrderTemplate;
use App\Factory;
class HttpRequestOrderInsert extends HttpRequestOrderTemplate
{

    public function requestContext()
    {
        $this->factory = new Factory();
    }
    public function requestPreCreate(){
        parent::requestPreCreate();

    }
    public function requestCreate($post,$name)
    {
        $this->name=$name;
        $this->idType = $this->Type->findById((int)$post['type'])->getId();

        $this->idClient = $this->Client->findById((int)$post['client'])->getId();
        $this->idCoupon = $this->Coupon->findById((int)$post['coupon'])->getId();
        $this->idDeliverService = $this->DeliverService->findById((int)$post['deliveryService'])->getId();
        $this->discountCouponCoefficient = $this->Coupon->findById((int)$post['coupon'])->getDiscountCouponCoefficient();
        $this->discountCouponRub = $this->Coupon->findById((int)$post['coupon'])->getDiscountCouponRub();
        $this->postPoducts=$post['products'];

        foreach ($post['products'] as $key => $value) {
            $this->priceProducts[] = $this->Product->findByPriceId((int)$value)->getProductsPrice();
        }
        $this->priceDeliverService = $this->DeliverService->findByPriceId((int)$post['deliveryService'])->getDeliveryServicePrice();
    }
    public function requestPreInsert(){
        parent::requestPreInsert();
        $this->InsertOrder = ($this->factory->create('InsertOrderBuilder'))
            ->addClientId($this->idClient)
            ->addCouponId($this->idCoupon)
            ->addName($this->name)
            ->addDeliveryServiceId($this->idDeliverService)
            ->addTypeId($this->idType)
            ->addFullPrice($this->price)
            ->build();

    }


    public function requestInsertOrder()
    {
      $this->orderId=$this->Order->insert([
            'name_order' => $this->InsertOrder->name,
            'full_price' => $this->InsertOrder->fullPrice,
            'coupon_id' => $this->InsertOrder->couponId,
            'client_id' => $this->InsertOrder->clientId,
            'delivery_service_id' => $this->InsertOrder->deliveryServiceId,
            'type_id' => $this->InsertOrder->typeId
        ]);



    }
    public function requestInsertOrderProduct(){
       $orderId=$this->orderId->getId();

        foreach ($this->postPoducts as $key=>$value){
            $this->OrderProduct->insert([
                'order_id' =>$orderId,
                'product_id'=>$value
            ]);

        }

    }

    public function requestInsertParser($products)
    {
        foreach ($products as $key => $value) {
            $parseName=uniqid();
           $this->Parser->insert(
                ['parser_name' => $parseName,
                    'product_id' => (int)$value
                ]

        );

        }

    }
}