<?php
declare(strict_types=1);

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

final class BankStatementJobFinished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public string $startDate;

    /**
     * @var string
     */
    public string $endDate;

    /**
     * @var string
     */
    public string $jobGuid;

    /**
     * @var string
     */
    public string $report;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $startDate, string $endDate, string $jobGuid, string $report)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->jobGuid = $jobGuid;
        $this->report = $report;
    }
}
