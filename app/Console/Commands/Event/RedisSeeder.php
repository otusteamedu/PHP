<?php

namespace App\Console\Commands\Event;

use App\Services\Event\EventService;
use App\Services\Event\Repositories\Eloquent\EloquentSearchEventRepository;

use Illuminate\Console\Command;

class RedisSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:redis:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill Redis storage data from DB';

    private EloquentSearchEventRepository $eloquentSearchEventRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        EloquentSearchEventRepository $eloquentSearchEventRepository
    )
    {
        parent::__construct();
        $this->eloquentSearchEventRepository = $eloquentSearchEventRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $events = $this->eloquentSearchEventRepository->getEvents();
        return 0;
    }
}
