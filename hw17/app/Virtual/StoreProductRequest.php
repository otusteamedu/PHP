<?php


namespace App\Virtual;


/**
 * @OA\Schema(
 *      title="Store Product request",
 *      description="Store Product request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class StoreProductRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the product",
     *      example="JavaScript Course"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Detail",
     *      description="Description of the product",
     *      example="Helpers for PHP developer"
     * )
     *
     * @var string
     */
    public $detail;
}
