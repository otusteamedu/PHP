<?php


namespace App\Service\FlightSchedule;


use App\Entity\Airline;
use App\Entity\City;
use App\Entity\FlightSchedule;
use Doctrine\ORM\EntityManagerInterface;
use JsonSerializable;

/**
 * @author Alexandr Timofeev <tim31al@gmail.com>
 *
 * Class FlightScheduleService
 * @package App\Service\FlightSchedule
 */
class FlightScheduleService implements FlightScheduleServiceInterface
{
    const MAX_LIMIT = 20;
    const RAW_KEYS = ['airline_id', 'departure_id', 'arrival_id', 'departure_time'];

    private EntityManagerInterface $entityManager;

    /**
     * FlightScheduleService constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Создать запись в расписании
     *
     * @param array $raw
     * @return \JsonSerializable|null
     */
    public function create(array $raw): ?JsonSerializable
    {
        if (!$this->validate($raw)) {
            return null;
        }

        $flight = new FlightSchedule();

        if ($this->saveFlight($flight, $raw)) {
            return $flight;
        }

        return null;

    }

    /**
     * @param int $id
     * @return \JsonSerializable|null
     */
    public function read(int $id): ?JsonSerializable
    {
        return $this->getFlight($id);
    }

    /**
     * @param array $raw
     * @return bool
     */
    public function update(array $raw): bool
    {
        if (!$this->validate($raw)) {
            return false;
        }

        $id = (int)$raw['id'] ?? 0;
        $flight = $this->getFlight($id);

        if (!$flight || !$this->saveFlight($flight, $raw)) {
            return false;
        }

        return true;
    }

    /**
     * Удалить запись
     * @param int $id
     * @return bool
     */
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

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function getAll(int $limit = null, int $offset = null): array
    {
        $limit = $limit ?? self::MAX_LIMIT;
        $offset = $offset ?? 0;

        return $this->entityManager
            ->getRepository(FlightSchedule::class)
            ->findBy([], null, $limit, $offset);
    }

    /**
     * Поиск записей по дате
     *
     * @param string $date
     * @return array|null
     */
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
            return null;
        }

    }

    /**
     * Получить запись
     * @param int $id
     * @return \App\Entity\FlightSchedule|null
     */
    private function getFlight(int $id): ?FlightSchedule
    {
        /** @var FlightSchedule $flight */
        $flight = $this->entityManager
            ->getRepository(FlightSchedule::class)
            ->find($id);

        return $flight;
    }

    private function getAirline(int $id): ?Airline
    {
        /** @var Airline $airline */
        $airline = $this->entityManager
            ->getRepository(Airline::class)
            ->find($id);

        return $airline;
    }

    private function getCity(int $id): ?City
    {
        /** @var City $city */
        $city = $this->entityManager
            ->getRepository(City::class)
            ->find($id);

        return $city;
    }

    private function validate(array $raw): bool
    {
        foreach (self::RAW_KEYS as $key) {
            if (!array_key_exists($key, $raw)) {
                return false;
            }
        }

        return true;
    }

    private function saveFlight(FlightSchedule $flight, array $raw): bool
    {
        try {
            $airline = $this->getAirline((int)$raw['airline_id']);
            $departure = $this->getCity((int)$raw['departure_id']);
            $arrival = $this->getCity((int)$raw['arrival_id']);
            $departureTime = new \DateTime($raw['departure_time']);

            if (!$airline || !$departure || !$arrival || !$departureTime) {
                return false;
            }

            $flight
                ->setAirline($airline)
                ->setDeparture($departure)
                ->setArrival($arrival)
                ->setDepartureTime($departureTime);

            $this->entityManager->persist($flight);
            $this->entityManager->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


}
