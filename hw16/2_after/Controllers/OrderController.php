<?php
declare(strict_types=1);

namespace CodeArchitecture\After\Controllers;

use CodeArchitecture\After\Formatters\FormatterInterface;
use CodeArchitecture\After\Repositories\RepositoryInterface;

class OrderController
{
    /**
     * @var RepositoryInterface
     */
    private RepositoryInterface $orderRepository;

    /**
     * @var FormatterInterface
     */
    private FormatterInterface $orderFormatter;

    /**
     * OrderService constructor.
     *
     * @param RepositoryInterface $orderRepository
     * @param FormatterInterface $orderFormatter
     */
    public function __construct(RepositoryInterface $orderRepository, FormatterInterface $orderFormatter)
    {
        $this->orderRepository = $orderRepository;
        $this->orderFormatter = $orderFormatter;
    }

    /**
     * @param string $orderNumber
     * @param string $dateFrom
     * @param string $dateBetween
     *
     * @return mixed
     */
    public function getOrders(string $orderNumber, string $dateFrom, string $dateBetween): mixed
    {
        $results = $this->orderRepository->getOrdersBrief($orderNumber, $dateFrom,  $dateBetween);

        return $this->orderFormatter->format($results);
    }
}
