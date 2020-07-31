<?php
namespace Ozycast\App\Mappers;

use Exception;
use Ozycast\App\Core\DTO;
use Ozycast\App\Core\Mapper;
use Ozycast\App\DTO\Client;

class ClientMapper extends Mapper
{
    /**
     * @var string
     */
    protected $collectName = "clients";

    protected static function getDTO() {
        return new Client();
    }

}