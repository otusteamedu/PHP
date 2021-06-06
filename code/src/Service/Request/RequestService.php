<?php


namespace App\Service\Request;


use App\Entity\Request;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestService implements RequestServiceInterface
{
    private EntityManagerInterface $entityManager;

    /**
     * RequestService constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function getRequestStatus(int $number): ?\JsonSerializable
    {
        /** @var Request $request */
        $request = $this->entityManager
            ->getRepository(Request::class)
            ->find($number);

        return $request;
    }

    public function addRequest(ServerRequestInterface $request, string $entity): int
    {
        $data['entity'] = $entity;

        $method = $request->getMethod();
        $data['method'] = $method;

        if ($method === 'DELETE') {
            $data['data']['id'] = (int) $request->getAttribute('id');
        } else {
            $data['data'] = $request->getParsedBody();
        }

        $json = json_encode($data);

        $requestRecord = new Request();
        $requestRecord->setContext($json);
        $this->entityManager->persist($requestRecord);
        $this->entityManager->flush();

        return $requestRecord->getId();

//        dump(json_decode($json));
//        return 1;
    }
}
