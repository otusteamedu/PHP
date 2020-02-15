<?php declare(strict_types=1);

namespace Controller\Shop;

use Entity\Shop\Customer;
use Service\Database\PDOFactory;
use Service\DataMapper\CustomerMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomersController
{
    public function getAction(Request $request): Response
    {
        $id = (int)explode('/', $request->getPathInfo())[3];
        $limit = $request->query->getInt('limit', 10);

        $pdoFactory = new PDOFactory();
        $customerMapper = new CustomerMapper($pdoFactory->getPostgresPDO());

        if ($id === 0) {
            $customers = $customerMapper->findAll($limit);

            return new Response(json_encode($customers));
        } else {
            if (($customer = $customerMapper->findById($id)) === null) {
                throw new \RuntimeException('Customer not found', Response::HTTP_NOT_FOUND);
            }

            return new Response(json_encode($customer));
        }
    }

    public function postAction(Request $request): Response
    {
        $customer = new Customer();
        $customer->handleArray(json_decode($request->getContent(), true));

        $pdoFactory = new PDOFactory();
        $customerMapper = new CustomerMapper($pdoFactory->getPostgresPDO());

        $customer = $customerMapper->insert($customer);

        return new Response(json_encode($customer));
    }

    public function deleteAction(Request $request): Response
    {
        $id = (int)explode('/', $request->getPathInfo())[3];

        $pdoFactory = new PDOFactory();
        $customerMapper = new CustomerMapper($pdoFactory->getPostgresPDO());

        if (($customer = $customerMapper->findById($id)) === null) {
            throw new \RuntimeException('Order not found', Response::HTTP_NOT_FOUND);
        }
        $customerMapper->delete($customer);

        return new Response(json_encode($customer));
    }

    public function patchAction(Request $request): Response
    {
        $id = (int)explode('/', $request->getPathInfo())[3];

        $pdoFactory = new PDOFactory();
        $customerMapper = new CustomerMapper($pdoFactory->getPostgresPDO());

        if (($customer = $customerMapper->findById($id)) === null) {
            throw new \RuntimeException('Order not found', Response::HTTP_NOT_FOUND);
        }
        $customer->handleArray(json_decode($request->getContent(), true));
        $customerMapper->update($customer);

        return new Response(json_encode($customer));
    }
}
