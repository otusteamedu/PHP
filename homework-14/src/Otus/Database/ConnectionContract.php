<?php

namespace Otus\Database;

use PDO;

interface ConnectionContract
{
    public function getPdo(): PDO;
}
