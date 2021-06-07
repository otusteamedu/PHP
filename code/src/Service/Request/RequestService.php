<?php


namespace App\Service\Request;


use App\Entity\Request;
use App\Service\Message\Messages\RequestMessage;
use App\Service\Message\MessageServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * @author Alexandr Timofeev <tim31al@gmail.com>
 *
 * Class RequestService
 * @package App\Service\Request
 */
class RequestService implements RequestServiceInterface
{
    private EntityManagerInterface $entityManager;
    private MessageServiceInterface $messageService;

    /**
     * RequestService constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, MessageServiceInterface $messageService)
    {
        $this->entityManager = $entityManager;
        $this->messageService = $messageService;
    }


    /**
     * Статус запроса
     *
     * @param int $number
     * @return \JsonSerializable|null
     */
    public function getRequestStatus(int $number): ?\JsonSerializable
    {
        /** @var Request $request */
        $request = $this->entityManager
            ->getRepository(Request::class)
            ->find($number);

        return $request;
    }

    /**
     * Добавить запрос в очередь для обработки
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param string $service
     * @return int
     */
    public function addRequest(ServerRequestInterface $request, string $service): int
    {
        $json = $this->getData($request, $service);

        $requestRecord = new Request();
        $requestRecord->setContext($json);
        $this->entityManager->persist($requestRecord);
        $this->entityManager->flush();

        $message = new RequestMessage($requestRecord->getId());
        $this->messageService->push($message);

        return $requestRecord->getId();
    }

    /**
     * Получить данные с запроса
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param string $service
     * @return string
     */
    private function getData(ServerRequestInterface $request, string $service): string
    {
        $data['service'] = $service;

        $method = $request->getMethod();
        $data['method'] = $method;

        if ($method === 'DELETE') {
            $data['data']['id'] = (int) $request->getAttribute('id');
        } else {
            $data['data'] = $request->getParsedBody();
        }

        return json_encode($data);
    }
}
