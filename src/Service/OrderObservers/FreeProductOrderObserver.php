<?php declare(strict_types=1);

namespace Service\OrderObservers;

use Entity\Shop\AbstractOrder;
use Entity\Shop\OrderProduct;
use Service\Database\PDOFactory;
use Service\DataMapper\OrderProductMapper;
use Service\DataMapper\ProductMapper;
use SplSubject;

class FreeProductOrderObserver implements \SplObserver
{
    public const FREE_PRODUCT_ID = 4;

    public const FREE_PRODUCT_THRESHOLD = 2000;

    private ProductMapper $productMapper;

    private OrderProductMapper $orderProductMapper;

    public function __construct()
    {
        $pdoFactory = new PDOFactory();
        $postgresPDO = $pdoFactory->getPostgresPDO();
        $this->productMapper = new ProductMapper($postgresPDO);
        $this->orderProductMapper = new OrderProductMapper($postgresPDO);
    }

    public function update(SplSubject $subject)
    {
        /** @var AbstractOrder $subject */
        if ($subject->getSum() >= self::FREE_PRODUCT_THRESHOLD) {
            $orderProducts = $subject->getOrderProducts();

            $freeProduct = $this->productMapper->findById(self::FREE_PRODUCT_ID);
            $orderProduct = new OrderProduct();
            $orderProduct->setOrder($subject);
            $orderProduct->setProduct($freeProduct);
            $orderProduct->setSum(0);
            $this->orderProductMapper->insert($orderProduct);
            $orderProducts[] = $orderProduct;

            $subject->setOrderProducts($orderProducts);
        }
    }
}
