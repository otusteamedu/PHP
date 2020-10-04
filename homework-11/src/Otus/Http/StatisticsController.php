<?php

namespace Otus\Http;

use Otus\Exceptions\InvalidDataFormatException;
use Otus\Statistics;

class StatisticsController
{
    private Statistics $statistics;

    public function __construct()
    {
        $this->statistics = new Statistics();
    }

    public function index(Request $request): ResponseContract
    {
        try {
            $collection = $this->statistics->get($request->get('limit', 5));
        } catch (InvalidDataFormatException $exception) {
            return new JsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }

        return new JsonResponse(Response::HTTP_OK, $collection);
    }
}
