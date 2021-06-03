<?php
declare(strict_types=1);

namespace App\Repositories\Reports;

use stdClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BankStatementRepository
{
    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $jobGuid
     * @param string $report
     *
     * @return bool
     */
    public function insert(string $startDate, string $endDate, string $jobGuid, string $report): bool
    {
        return DB::table('reports')->insert(
            [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'job_guid' => $jobGuid,
                'report' => $report,
                'created_at' => Carbon::now()
            ]
        );
    }

    /**
     * @param string $column
     * @param string $value
     *
     * @return ?stdClass
     */
    public function findBy(string $column, string $value): ?stdClass
    {
        return DB::table('reports')->where($column, $value)->first();
    }
}
