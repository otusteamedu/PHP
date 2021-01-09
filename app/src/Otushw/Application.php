<?php


namespace Otushw;

use Otushw\DBSystem\NoSQLDAO;

interface Application
{
    public function __construct(NoSQLDAO $db);
}