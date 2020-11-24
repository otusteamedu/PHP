<?php

namespace App\Jobs;

use App\Models\Message;
use Carbon\Carbon;

class MessageJob extends Job
{
    public function handle(): void
    {
        $message = Message::findOrFail($this->job->getJobId());

        $message->status = 'processing';
        $message->save();

        sleep(random_int(10, 30));

        $message->status = 'processed';
        $message->save();
    }
}
