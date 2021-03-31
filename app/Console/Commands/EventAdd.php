<?php

namespace App\Console\Commands;

use App\Services\Events\EventService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class EventAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:add {name} {priority} {conditions*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add event';

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
        $event = [
            'name'       => $this->argument('name'),
            'priority'   => $this->argument('priority'),
            'conditions' => collect($this->argument('conditions'))->mapWithKeys(static function ($item) {
                return [current(explode(':', $item)) => last(explode(':', $item))];
            })->toArray()
        ];
        $service->add($event);
        $this->info("Event [{$event['name']}] has been added");
        return 0;
    }
}
