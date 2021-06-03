<?php
declare(strict_types=1);

namespace App\Jobs\Reports;

use App\Events\BankStatementJobFinished;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Str;

final class BankStatementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|mixed
     */
    private string $startDate;

    /**
     * @var string|mixed
     */
    private string $endDate;

    /**
     * @var string
     */
    private string $jobGuid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $dates, string $jobGuid)
    {
        $this->startDate = $dates['from'];
        $this->endDate = $dates['to'];
        $this->jobGuid = $jobGuid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        //imitating complex computing ;)
        sleep(rand(1, 10));

        //pretend calculated report
        $result = Str::random(100);

        event(new BankStatementJobFinished($this->startDate, $this->endDate, $this->jobGuid, $result));
    }
}
