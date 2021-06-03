<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;
use OpenApi\Annotations as OA;


/**
 * Class NotFoundDTO
 * @package App\DTO
 *
 * @OA\Schema ()
 */
final class NotFoundDTO extends AbstractDTO
{

    /**
     * NotFoundDTO constructor.
     */
    public function __construct()
    {
        $this->statusCode = StatusCodeInterface::STATUS_NOT_FOUND;
        $this->data = ['message' => 'Not found'];
    }

}
