<?php
namespace Ozycast\App\Mappers;

use Exception;
use Ozycast\App\Core\DTO;
use Ozycast\App\Core\Mapper;
use Ozycast\App\DTO\Delivery;

class DeliveryMapper extends Mapper
{
    /**
     * @var string
     */
    protected $collectName = "delivery";

    protected static function getDTO() {
        return new Delivery();
    }

}