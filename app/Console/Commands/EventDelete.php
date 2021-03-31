<?php

namespace App\Console\Commands;

use App\Services\Events\EventService;
use Illuminate\Console\Command;

class EventDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:delete {--name=} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(EventService $service)
    {
        if ($this->option('all') && $this->confirm('Do you really want to clean all events?', false)) {
            $service->clear();
            $this->info('All events have been removed');
        } elseif (is_string($this->option('name')) && !empty($this->option('name'))) {
            $service->delete($this->option('name'));
            $this->info("Event [{$this->option('name')}] has been deleted");
        }
        return 0;
    }
}
