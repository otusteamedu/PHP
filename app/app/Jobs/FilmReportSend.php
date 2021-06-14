<?php

namespace App\Jobs;

use App\Mails\FilmDurationReport;
use App\Models\Film;
use App\Models\UserRequest;
use Illuminate\Support\Facades\Mail;

class FilmReportSend extends Job
{
    public int $userRequestId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userRequestId)
    {
        $this->userRequestId = $userRequestId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userRequest = UserRequest::findOrFail($this->userRequestId);

        Mail::to($userRequest->email)->send(new FilmDurationReport(Film::all()));

        $userRequest->update(['status' => UserRequest::COMPLETED]);
    }
}
