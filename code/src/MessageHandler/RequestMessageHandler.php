<?php


namespace App\MessageHandler;


use App\Entity\Request;
use App\Message\MessageInterface;
use App\Message\RequestMessage;
use App\Service\CrudInterface;
use Doctrine\ORM\EntityManagerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

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


    /** @var \App\Message\RequestMessage $message */
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

    private function getData(): array
    {
        return json_decode($this->request->getContext(), true);
    }

    private function setResult(int $result): void
    {
        $this->request->setResult($result);
    }

    private function getService(array $data): CrudInterface
    {
        $service = $data['service'];

        return $this->container->get($service);
    }

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
