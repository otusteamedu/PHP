<?php

declare(strict_types=1);

namespace App\Command;

use App\Framework\Command\AbstractCommand;
use PDO;

class RunMigrationCommand extends AbstractCommand
{
    private PDO $pdoConnection;

    public function __construct(PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    protected function fillExpectedArguments(): void
    {

    }

    protected function execute(): void
    {
        $this->console->info('Применение миграций...');

        $this->pdoConnection->exec(
            'create table if not exists requests (
                        id varchar(36) not null constraint requests_pk primary key,
                        name varchar(255),
                        creation_date timestamp not null,
                        status integer not null
                    );'
        );

        $this->console->success('Миграции применены');
    }
}