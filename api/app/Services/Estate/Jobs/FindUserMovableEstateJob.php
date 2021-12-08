<?php
/**
 * Description of FindUserMovableEstateJob.php
 * @copyright Copyright (c) valyakin.ru
 * @author    Vladimir Valyakin <vladimir@valyakin.ru>
 */

declare(strict_types=1);

namespace App\Services\Estate\Jobs;

use App\Models\User;
use App\Services\Estate\Handlers\FindUserMovableEstateHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class FindUserMovableEstateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    const QUEUE_NAME = 'findUserMovableEstate';

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->onQueue(self::QUEUE_NAME);
    }

    private function getStoreUserHandler(): FindUserMovableEstateHandler
    {
        return app(FindUserMovableEstateHandler::class);
    }

    public function handle()
    {
        $this->getStoreUserHandler()->handle(
            $this->user,
        );
    }
}
