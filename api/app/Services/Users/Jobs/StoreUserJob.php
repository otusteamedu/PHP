<?php

namespace App\Services\Users\Jobs;

use App\Services\Users\DTO\StoreUserDTO;
use App\Services\Users\Handlers\StoreUserHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class StoreUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    const QUEUE_NAME = 'storeUser';

    private StoreUserDTO $dto;

    public function __construct(StoreUserDTO $dto)
    {
        $this->dto = $dto;
        $this->onQueue(self::QUEUE_NAME);
    }

    private function getStoreUserHandler(): StoreUserHandler
    {
        return app(StoreUserHandler::class);
    }

    public function handle()
    {
        $this->getStoreUserHandler()->handle(
            $this->dto,
        );
    }
}
