<?php
namespace Ozycast\App\Mappers;

use Exception;
use Ozycast\App\Core\DTO;
use Ozycast\App\Core\Mapper;
use Ozycast\App\DTO\Discount;

class DiscountMapper extends Mapper
{
    /**
     * @var string
     */
    protected $collectName = "discounts";

    protected static function getDTO() {
        return new Discount();
    }

}