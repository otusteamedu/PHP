<?php

namespace App\Console\Commands;

use App\Services\Events\EventService;
use Illuminate\Console\Command;

class EventSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:search {conditions*}';

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
        $event = $service->getEventByCondition(collect($this->argument('conditions'))->mapWithKeys(static function ($item) {
            return [current(explode(':', $item)) => last(explode(':', $item))];
        })->toArray());
        if (is_null($event)) {
            $this->info('No matching events');
        } else {
            $this->info('Event is found. Each condition has _ prefix');
            $event = collect($event)->only('name', 'priority')
                ->merge(collect($event['conditions'])
                    ->mapWithKeys(static function($v, $k){
                        return ["_$k" => $v];
                    }));
            $this->table($event->keys()->toArray(), [$event->toArray()]);
        }
        return 0;
    }
}
