<?php declare(strict_types=1);

namespace Service;

use Entity\Shop\AbstractOrder;
use Entity\Shop\B2bOrder;
use Entity\Shop\B2cOrder;
use Entity\Shop\OrderProduct;
use Entity\Shop\OrderProductShipment;
use Entity\Shop\Shipment;
use Service\Database\PDOFactory;
use Service\DataMapper\CustomerMapper;
use Service\DataMapper\DiscountMapper;
use Service\DataMapper\OrderMapper;
use Service\DataMapper\OrderProductMapper;
use Service\DataMapper\OrderProductShipmentMapper;
use Service\DataMapper\ProductMapper;
use Service\DataMapper\ShipmentMapper;
use Service\DataMapper\ShippingSystemMapper;
use Service\Exception\OrderFactoryException;
use Service\OrderNotifier\EmailNotifier;
use Service\OrderNotifier\SmsNotifier;
use Service\OrderObservers\FreeProductOrderObserver;
use Service\OrderObservers\FreeShippingOrderObserver;
use Symfony\Component\HttpFoundation\Request;

class OrderFactory
{
    private PDOFactory $pdoFactory;

    private CustomerMapper $customerMapper;

    private DiscountMapper $discountMapper;

    private OrderMapper $orderMapper;

    private OrderProductMapper $orderProductMapper;

    private ProductMapper $productMapper;

    private ShipmentMapper $shipmentMapper;

    private ShippingSystemMapper $shippingSystemMapper;

    private OrderProductShipmentMapper $orderProductShipmentMapper;

    public function __construct()
    {
        $this->pdoFactory = new PDOFactory();
        $postgresPDO = $this->pdoFactory->getPostgresPDO();
        $this->customerMapper = new CustomerMapper($postgresPDO);
        $this->discountMapper = new DiscountMapper($postgresPDO);
        $this->orderMapper = new OrderMapper($postgresPDO);
        $this->orderProductMapper = new OrderProductMapper($postgresPDO);
        $this->productMapper = new ProductMapper($postgresPDO);
        $this->shipmentMapper = new ShipmentMapper($postgresPDO);
        $this->shippingSystemMapper = new ShippingSystemMapper($postgresPDO);
        $this->orderProductShipmentMapper = new OrderProductShipmentMapper($postgresPDO);
    }

    public function createOrder(Request $request): AbstractOrder
    {
        $orderArray = json_decode($request->getContent(), true);

        switch ($orderArray['type']) {
            case AbstractOrder::ORDER_TYPE_B2B:
                $order = new B2bOrder();
                $order->setNotifier(new EmailNotifier());
                break;
            case AbstractOrder::ORDER_TYPE_B2C:
                $order = new B2cOrder();
                $order->setNotifier(new SmsNotifier());
                break;
            default:
                throw new OrderFactoryException('Incorrect order type');
        }
        $order->attach(new FreeProductOrderObserver());
        $order->attach(new FreeShippingOrderObserver());

        $order->setCreatedAt(new \DateTime());

        $customer = $this->customerMapper->findById($orderArray['customer_id']);
        $order->setCustomer($customer);

        if (isset($orderArray['promocode'])) {
            $discount = $this->discountMapper->findByPromocode($orderArray['promocode']);
            $order->setDiscount($discount);
        }

        $this->orderMapper->insert($order);

        $shippingSystem = $this->shippingSystemMapper->findById($orderArray['shipping_system_id']);

        $shipment = new Shipment();
        $shipment->setDate(new \DateTime('+1 day'));
        $shipment->setShippingSystem($shippingSystem);
        $shipment->setSum($shippingSystem->getSum());
        $shipment->setOrder($order);
        $this->shipmentMapper->insert($shipment);

        $order->setShipments([$shipment]);

        $orderProducts = [];
        foreach ($orderArray['product_ids'] as $productId) {
            $product = $this->productMapper->findById($productId);
            $orderProduct = new OrderProduct();
            $orderProduct->setOrder($order);
            $orderProduct->setProduct($product);
            $orderProduct->setSum($product->getSum());
            $this->orderProductMapper->insert($orderProduct);

            $orderProducts[] = $orderProduct;

            $orderProductShipment = new OrderProductShipment();
            $orderProductShipment->setOrderProduct($orderProduct);
            $orderProductShipment->setShipment($shipment);
            $this->orderProductShipmentMapper->insert($orderProductShipment);
        }
        $order->setOrderProducts($orderProducts);

        $this->orderMapper->update($order);
        $order->notify();

        return $order;
    }
}
