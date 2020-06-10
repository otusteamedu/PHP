<?php

namespace App\Service;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends Exception implements NotFoundExceptionInterface
{
}
