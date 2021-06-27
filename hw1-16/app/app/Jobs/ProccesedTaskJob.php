<?php

namespace App\Jobs;

use App\Models\Task;

class ProccesedTaskJob extends Job
{
    private Task $task;

    const PROCCESED = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(rand(1, 20));
        $this->task->status = self::PROCCESED;
        $this->task->save();
    }
}
