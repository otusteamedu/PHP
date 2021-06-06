<?php


namespace App\Service\FlightSchedule;


use App\Entity\FlightSchedule;
use Doctrine\ORM\EntityManagerInterface;
use JsonSerializable;
use Psr\Log\LoggerInterface;

class FlightScheduleService implements FlightScheduleServiceInterface
{
    const MAX_LIMIT = 20;

    private EntityManagerInterface $entityManager;

    /**
     * FlightScheduleService constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function create(array $raw): ?JsonSerializable
    {
        // TODO: Implement create() method.
    }

    public function read(int $id): ?JsonSerializable
    {
        return $this->getFlight($id);
    }

    public function update(array $raw): bool
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): bool
    {
        $flight = $this->getFlight($id);

        try {
            $this->entityManager->remove($flight);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getAll(int $limit = null, int $offset = null): array
    {
        $limit = $limit ?? self::MAX_LIMIT;
        $offset = $offset ?? 0;

        return $this->entityManager
            ->getRepository(FlightSchedule::class)
            ->findBy([], null, $limit, $offset);
    }

    public function findByDate(string $date): ?array
    {
        try {
            $qb = $this->entityManager->createQueryBuilder()
                ->select('f')
                ->from('App\Entity\FlightSchedule', 'f')
                ->where('DATE_DIFF(f.departureTime, ?1) = 0')
                ->setParameter(1, new \DateTime($date));

            return $qb->getQuery()->getResult();
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
            return null;
        }

    }

    private function getFlight(int $id): ?FlightSchedule
    {
        /** @var FlightSchedule $flight */
        $flight = $this->entityManager
            ->getRepository(FlightSchedule::class)
            ->find($id);

        return $flight;
    }

    private function validate(array $raw): bool
    {

    }


}
