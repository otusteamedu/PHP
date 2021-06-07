<?php


namespace App\Service\Message\MessageHandlers;


use App\Entity\Request;
use App\Service\Message\Messages\MessageInterface;
use App\Service\CrudInterface;
use App\Service\Message\Messages\RequestMessage;
use Doctrine\ORM\EntityManagerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Alexandr Timofeev <tim31al@gmail.com>
 *
 * Class RequestMessageHandler
 * @package App\MessageHandlers
 */
class RequestMessageHandler implements MessageHandlerInterface
{
    const PROCESSING = 1;
    const PROCESSED = 2;

    private EntityManagerInterface $entityManager;
    private ContainerInterface $container;
    private Request $request;
    private LoggerInterface $logger;

    /**
     * RequestMessageHandler constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
        $this->logger = $container->get(LoggerInterface::class);
    }


    /** @var \App\Service\Message\Messages\RequestMessage $message */
    public function process(MessageInterface $message)
    {
        try {
            $this->setRequest($message);
            $this->setState(self::PROCESSING);

            $data = $this->getData();
            $service = $this->getService($data);

            $goodResult = StatusCodeInterface::STATUS_OK;
            $raw = $data['data'];
            $isGood = false;

            switch($data['method']) {
                case 'DELETE':
                    $id = (int) $raw['id'];
                    $isGood = $service->delete($id);
                    break;
                case 'POST':
                    $isGood = $service->create($raw);
                    $goodResult = StatusCodeInterface::STATUS_CREATED;
                    break;
                case 'PUT':
                    $isGood = $service->update($raw);
                    break;
            }

            $result = $isGood ? $goodResult : StatusCodeInterface::STATUS_BAD_REQUEST;

            $this->setResult($result);
            $this->setState(self::PROCESSED);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage() . '. ' . $e->getFile() . ':' . $e->getLine());
        }
    }

    /**
     * Установить статус обработки
     * @param int $state
     */
    private function setState(int $state): void
    {
        if ($state === self::PROCESSING) {
            $this->request->setStateProcessing();
        } elseif ($state === self::PROCESSED) {
            $this->request->setStateProcessed();
        }

        $this->entityManager->persist($this->request);
        $this->entityManager->flush();
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return json_decode($this->request->getContext(), true);
    }

    /**
     * Установить результат обработки
     * @param int $result
     */
    private function setResult(int $result): void
    {
        $this->request->setResult($result);
    }

    /**
     * Получить сервис из контекста запроса
     * @param array $data
     * @return \App\Service\CrudInterface
     */
    private function getService(array $data): CrudInterface
    {
        $service = $data['service'];

        return $this->container->get($service);
    }


    /**
     * Получить запрос
     *
     * @param \App\Service\Message\Messages\RequestMessage $message
     */
    private function setRequest(RequestMessage $message): void
    {
        $number = $message->getRequestNumber();

        /** @var Request $request */
        $request = $this->entityManager
            ->getRepository(Request::class)
            ->find($number);

        $this->request = $request;
    }
}
