<?php

declare(strict_types=1);

namespace App\Model\Request\Repository;

use App\Model\Request\Entity\Id;
use App\Model\Request\Entity\Request;

interface RequestRepositoryInterface
{
    public function getOne(Id $id): Request;
}