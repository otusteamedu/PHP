<?php
declare(strict_types=1);

namespace App\Controllers;

use PDO;
use App\Models\Hall;
use App\Models\Cinema;
use Symfony\Component\HttpFoundation\JsonResponse;

class CinemasController
{
    /**
     * CinemasController constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return JsonResponse
     */
    public function cinemaIndex(): JsonResponse
    {
        $cinemas = [];
        foreach (Cinema::cursor($this->pdo) as $cinema) {
            $cinemas[] = $cinema->toArray();
        }

        return new JsonResponse(['cinemas' => $cinemas]);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function cinemaHallsIndex(string $id): JsonResponse
    {
        $cinema = Cinema::find($this->pdo, (int) $id);

        $halls = [];
        foreach ($cinema->getHalls() as $hall) {
            $halls[] = $hall->toArray();
        }

        return new JsonResponse(['halls' => $halls]);
    }

    /**
     * @return JsonResponse
     */
    public function hallIndex(): JsonResponse
    {
        $halls = [];
        foreach (Hall::cursor($this->pdo) as $hall) {
            $halls[] = $hall->toArray();
        }

        return new JsonResponse(['halls' => $halls]);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function hallCinemasIndex(string $id): JsonResponse
    {
        $hall = Hall::find($this->pdo, (int) $id);
        $cinema = $hall ? $hall->getCinema() : null;

        return new JsonResponse(['cinema' => $cinema->toArray()]);
    }
}
