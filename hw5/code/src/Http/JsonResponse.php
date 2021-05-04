<?php
declare(strict_types=1);

namespace App\Http;

/**
 * Class JsonResponse
 */
class JsonResponse extends Response
{
    /**
     * @param array $json
     * @param int   $statusCode
     */
    public function __construct(array $json, int $statusCode = 200)
    {
        parent::__construct(
            json_encode($json),
            $statusCode
        );
    }

    /**
     * {@inheritDoc}
     */
    public function send(): void
    {
        header('Content-Type: application/json');

        parent::send();
    }
}
