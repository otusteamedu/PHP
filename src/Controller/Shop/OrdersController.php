<?php declare(strict_types=1);

namespace Controller\Shop;

use Entity\Shop\AbstractOrder;
use Entity\Shop\OrderProduct;
use Entity\Shop\Shipment;
use Service\Database\PDOFactory;
use Service\DataMapper\CustomerMapper;
use Service\DataMapper\DiscountMapper;
use Service\DataMapper\OrderMapper;
use Service\DataMapper\OrderProductMapper;
use Service\DataMapper\ProductMapper;
use Service\DataMapper\ShipmentMapper;
use Service\DataMapper\ShippingSystemMapper;
use Service\OrderFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersController
{
    public function postAction(Request $request): Response
    {
        $pdoFactory = new PDOFactory();
        $postgresPDO = $pdoFactory->getPostgresPDO();

        $customerMapper = new CustomerMapper($postgresPDO);
        $discountMapper = new DiscountMapper($postgresPDO);
        $orderMapper = new OrderMapper($postgresPDO);
        $orderProductMapper = new OrderProductMapper($postgresPDO);
        $productMapper = new ProductMapper($postgresPDO);
        $shipmentMapper = new ShipmentMapper($postgresPDO);
        $shippingSystemMapper = new ShippingSystemMapper($postgresPDO);

        $orderArray = json_decode($request->getContent(), true);
        $orderFactory = new OrderFactory();
        $order = $orderFactory->createOrder($orderArray['type']);
        $order->setCreatedAt(new \DateTime());
        $order->setStatus(AbstractOrder::ORDER_STATUS_NEW);
        $order->setSum(0);

        $customer = $customerMapper->findById($orderArray['customer_id']);
        $order->setCustomer($customer);

        if (isset($orderArray['promocode'])) {
            $discount = $discountMapper->findByPromocode($orderArray['promocode']);
            $order->setDiscount($discount);
        }

        $orderMapper->insert($order);

        $shippingSystem = $shippingSystemMapper->findById($orderArray['shipping_system_id']);

        $productSum = 0;
        $shipmentSum = 0;
        $shipmentDate = new \DateTime('+1 day');
        foreach ($orderArray['product_ids'] as $productId) {
            $product = $productMapper->findById($productId);
            $orderProduct = new OrderProduct();
            $orderProduct->setOrder($order);
            $orderProduct->setProduct($product);
            $orderProduct->setSum($product->getSum());
            $orderProductMapper->insert($orderProduct);

            $productSum += $product->getSum();

            $shipment = new Shipment();
            $shipment->setDate($shipmentDate);
            $shipment->setShippingSystem($shippingSystem);
            $shipment->setOrderProduct($orderProduct);
            $shipment->setSum($shipmentSum === 0 ? $shippingSystem->getSum() : 0);
            $shipmentMapper->insert($shipment);

            $shipmentSum += $shipment->getSum();
        }

        $discountSum = $order->getDiscount() === null ? 0 : $order->getDiscount()->getValue();
        $order->setSum(($shipmentSum + $productSum) - $discountSum * ($shipmentSum + $productSum) / 100);
        $orderMapper->update($order);

        return new Response('OK');
    }
}
