<?php


namespace App\Service\Airline;


use App\Entity\Airline;
use Doctrine\ORM\EntityManagerInterface;
use JsonSerializable;


final class AirlineService implements AirlineServiceInterface
{
    const MAX_LIMIT = 20;

    private EntityManagerInterface $entityManager;
    private AirlineValidator $validator;

    /**
     * Airline constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, AirlineValidator $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }


    /**
     * Create Airline
     *
     * @param array|null $raw
     * @return \JsonSerializable|null
     */
    public function create(?array $raw): ?JsonSerializable
    {
        if (! $this->validator->validate($raw)) {
            return null;
        }

        $airline = new Airline();
        return $this->saveAirline($airline, $raw) ? $airline : null;
    }

    /**
     * Get one Airline
     *
     * @param int $id
     * @return \JsonSerializable|null
     */
    public function read(int $id): ?JsonSerializable
    {
        return $this->getAirline($id);
    }

    /**
     * Update Airline
     *
     * @param array $raw
     * @return bool
     */
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

    /**
     * Delete Airline
     *
     * @param int id
     * @return bool
     */
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
     * Get All Airlines
     *
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function getAll(int $limit = null, int $offset = null): ?array
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
            ->find($id);

        return $airline;
    }

    /**
     * Сохранить авиакомпанию
     *
     * @param \App\Entity\Airline $airline
     * @param array $data
     * @return bool
     */
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
