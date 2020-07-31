<?php
namespace Ozycast\App\Mappers;

use Exception;
use Ozycast\App\Core\DTO;
use Ozycast\App\Core\Mapper;
use Ozycast\App\DTO\Product;

class ProductMapper extends Mapper
{
    /**
     * @var string
     */
    protected $collectName = "products";

    protected static function getDTO() {
        return new Product();
    }

}