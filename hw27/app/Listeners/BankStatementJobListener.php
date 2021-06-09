<?php
declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\BankStatementJobFinished;
use App\Repositories\Reports\BankStatementRepository;

final class BankStatementJobListener
{
    private BankStatementRepository $bankStatementRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BankStatementRepository $repository)
    {
        $this->bankStatementRepository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param BankStatementJobFinished $event
     *
     * @return void
     */
    public function handle(BankStatementJobFinished $event): void
    {
        try {
            $this->bankStatementRepository->insert($event->startDate, $event->endDate, $event->jobGuid, $event->report);
        } catch (\Exception $e) {
            Log::info('Error has occurred while writing report to DB!', [
                'start_date' => $event->startDate,
                'end_date' => $event->endDate,
                'job_guid' => $event->jobGuid,
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
                'previous_exception' => $e->getPrevious() ?? null,
                'trace' => $e->getTraceAsString()
            ]);
        }

    }
}
