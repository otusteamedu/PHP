<?php


namespace App\Service\AirlineService;


use App\Entity\Airline;
use Doctrine\ORM\EntityManagerInterface;
use JsonSerializable;
use Psr\Log\LoggerInterface;

final class AirlineService implements AirlineServiceInterface
{
    const MAX_LIMIT = 20;

    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;
    private AirlineValidator $validator;

    /**
     * AirlineService constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        AirlineValidator $validator
    )
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->validator = $validator;
    }


    public function create(?array $raw): ?JsonSerializable
    {
        if (! $this->validator->validate($raw)) {
            return null;
        }

        $airline = new Airline();
        return $this->saveAirline($airline, $raw) ? $airline : null;
    }

    public function read(int $id): ?JsonSerializable
    {
        return $this->getAirline($id);
    }

    public function update(array $raw): bool
    {
        $airline = $this->getAirline((int) $raw['id']);

        if (! $airline) {
            return false;
        }

        $data = array_slice($raw, 1);
        if (! $this->validator->validate($data)) {
            return false;
        }

        return $this->saveAirline($airline, $data);
    }

    public function delete(int $id): bool
    {
        $airline = $this->getAirline($id);

        try {
            $this->entityManager->remove($airline);
            $this->entityManager->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAll(int $limit = null, int $offset = null): array
    {
        $limit = $limit ?? self::MAX_LIMIT;
        $offset = $offset ?? 0;

        return $this->entityManager
            ->getRepository(Airline::class)
            ->findBy([], null, $limit, $offset);
    }

    private function getAirline(int $id): ?Airline
    {
        /** @var Airline $airline */
        $airline = $this->entityManager
            ->getRepository(Airline::class)
            ->findOneBy(['id' => $id]);

        return $airline;
    }

    private function saveAirline(Airline $airline, array $data): bool
    {
        try {
            list ($title, $abbreviation, $description) = array_values($data);

            $airline
                ->setTitle($title)
                ->setAbbreviation($abbreviation)
                ->setDescription($description);

            $this->entityManager->persist($airline);
            $this->entityManager->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}
