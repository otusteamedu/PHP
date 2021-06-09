<?php
declare(strict_types=1);

namespace App\Services\Reports;

use stdClass;
use Illuminate\Support\Str;
use App\Jobs\Reports\BankStatementJob;
use App\Repositories\Reports\BankStatementRepository;

class BankStatementService
{
    /**
     * @var BankStatementRepository
     */
    protected BankStatementRepository $bankStatementRepository;

    /**
     * BankStatementService constructor.
     *
     * @param BankStatementRepository $bankStatementRepository
     */
    public function __construct(BankStatementRepository $bankStatementRepository)
    {
        $this->bankStatementRepository = $bankStatementRepository;
    }

    /**
     * @param array $dates
     *
     * @return string
     */
    public function generateReportAsync(array $dates): string
    {
        $jobGuid = Str::orderedUuid()->toString();
        BankStatementJob::dispatch($dates, $jobGuid);

        return $jobGuid;
    }

    /**
     * @param string $guid
     *
     * @return ?stdClass
     */
    public function getReportByGuid(string $guid): ?stdClass
    {
        return $this->bankStatementRepository->findBy('job_guid', $guid);
    }
}
