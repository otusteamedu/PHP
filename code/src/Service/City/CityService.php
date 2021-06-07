<?php


namespace App\Service\City;


use App\Entity\City;
use App\Utils\Validator\StringValidator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JsonSerializable;

class CityService implements CityServiceInterface
{
    const MAX_LIMIT = 20;
    const CITY_MAX_LENGTH = 100;
    const CITY_MIN_LENGTH = 3;

    private EntityManagerInterface $entityManager;
    private StringValidator $stringValidator;

    /**
     * City constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Utils\Validator\StringValidator $stringValidator
     */
    public function __construct(EntityManagerInterface $entityManager, StringValidator $stringValidator)
    {
        $this->entityManager = $entityManager;
        $this->stringValidator = $stringValidator;
    }


    /**
     * Create city
     *
     * @param array|null $raw
     * @return \JsonSerializable|null
     */
    public function create(?array $raw): ?JsonSerializable
    {
        if (!$this->validate($raw)) {
            return null;
        }

        $city = new City();

        return $this->saveCity($city, $raw) ? $city : null;
    }

    /**
     * Get city by id
     *
     * @param int $id
     * @return \JsonSerializable|null
     */
    public function read(int $id): ?JsonSerializable
    {
        return $this->getCity($id);
    }

    public function update(array $raw): bool
    {
        $city = $this->getCity((int) $raw['id']);
        if (!$city) {
            return false;
        }

        $data = array_slice($raw, 1);

        if (!$this->validate($data)) {
            return false;
        }

        return $this->saveCity($city, $data);
    }

    public function delete(int $id): bool
    {
        $city = $this->getCity($id);

        try {
            $this->entityManager->remove($city);
            $this->entityManager->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAll(int $limit = null, int $offset = null): ?array
    {
        $limit = $limit ?? self::MAX_LIMIT;
        $offset = $offset ?? 0;

        return $this->entityManager
            ->getRepository(City::class)
            ->findBy([], null, $limit, $offset);
    }


    private function getCity(int $id): ?City
    {
        /** @var City $city */
        $city = $this->entityManager
            ->getRepository(City::class)
            ->find($id);

        return $city;
    }


    private function validate(?array $raw): bool
    {
        if (null === $raw) {
            return false;
        }

        return $this->stringValidator
            ->validate($raw['name'], self::CITY_MAX_LENGTH, self::CITY_MIN_LENGTH);
    }

    private function saveCity(City $city, array $data): bool
    {
        try {
            list ($name) = array_values($data);

            $city->setName($name);

            $this->entityManager->persist($city);
            $this->entityManager->flush();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
