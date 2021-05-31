<?php
declare(strict_types=1);

namespace App\Services;

use Exception;
use App\DTOs\DTOInterface;
use App\Clients\RabbitClient;

class ReportService
{
    protected RabbitClient $rabbitClient;

    /**
     * ReportService constructor.
     *
     * @param RabbitClient $rabbitClient
     */
    public function __construct(RabbitClient $rabbitClient)
    {
        $this->rabbitClient = $rabbitClient;
    }

    /**
     * @param DTOInterface $dates
     *
     * @return void
     *
     * @throws Exception
     */
    public function createBankStatementReportAsync(DTOInterface $dates): void
    {
        $this->rabbitClient->initialize();
        $this->rabbitClient->dispatch("Generating reports: {$dates}...");
    }
}
