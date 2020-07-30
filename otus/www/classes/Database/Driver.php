<?php

namespace Classes\Database;

use Classes\Dto\DbConfigDto;
use PDO;

interface Driver
{
    public function getDriver(DbConfigDto $dbConfigDto): PDO;
}
