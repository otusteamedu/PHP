<?php


namespace App;

use App\ClientMapper;
use App\CouponMapper;
use App\Database;
use App\DeliverServiceMapper;
use App\DiscountDeliveryServiceMapper;
use App\DiscountProductMapper;
use App\OrderMapper;
use App\ParserMapper;
use App\ProductMapper;
use App\TypeMapper;
use App\InsertOrderBuilder;
use App\FullPriceBuilder;
use App\OrderProductMapper;
use App\ReceiverQueueRpcServer;
use App\SendQueueRpcClient;
use App\RabbitMQ;


/**
 * Class AbstractFactory
 * @package App
 */
abstract class AbstractFactory
{
    /**
     * @param $type
     * @return \App\ClientMapper|\App\CouponMapper|\App\DeliverServiceMapper|\App\DiscountDeliveryServiceMapper|\App\DiscountProductMapper|\App\FullPriceBuilder|\App\InsertOrderBuilder|\App\OrderMapper|\App\OrderProductMapper|\App\ParserMapper|\App\ProductMapper|\App\ReceiverQueueRpcServer|\App\SendQueueRpcClient|\App\TypeMapper|string
     */
    public function create($type)
    {
        $db = Database::getInstance();
        $db = $db->init();
        $RabbitMQ=RabbitMQ::getInstance();
        $RabbitMQ=$RabbitMQ->init();
        switch ($type) {
            case 'Client':
                return new ClientMapper($db);
            case 'Coupon':
                return new CouponMapper($db);
            case 'DeliverService':
                return new DeliverServiceMapper($db);
            case 'DiscountDeliveryService':
                return new DiscountDeliveryServiceMapper($db);
            case 'DiscountProduct':
                return new DiscountProductMapper($db);
            case 'Order':
                return new OrderMapper($db);
            case 'Parser':
                return new ParserMapper($db);
            case 'Product':
                return new ProductMapper($db);
            case 'Type':
                return new TypeMapper($db);
            case 'InsertOrderBuilder':
                return new InsertOrderBuilder();
            case 'FullPriceBuilder':
                return new FullPriceBuilder();
            case 'OrderProduct':
                return new OrderProductMapper($db);
            case 'ReceiverQueueRpcServer':
                return new ReceiverQueueRpcServer(new HttpRequestOrderInsert(), $RabbitMQ);
            case 'SendQueueRpcClient':
                return new SendQueueRpcClient($RabbitMQ);
            default:
                return 'Wrong Object';
        }
    }
}
