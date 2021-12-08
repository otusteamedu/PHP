<?php
/**
 * Description of FindUserRealEstateJob.php
 * @copyright Copyright (c) valyakin.ru
 * @author    Vladimir Valyakin <vladimir@valyakin.ru>
 */

declare(strict_types=1);

namespace App\Services\Estate\Jobs;

use App\Models\User;
use App\Services\Estate\Handlers\FindUserRealEstateHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class FindUserRealEstateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    const QUEUE_NAME = 'findUserMovableEstate';

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->onQueue(self::QUEUE_NAME);
    }

    private function getFindUserRealEstateHandler(): FindUserRealEstateHandler
    {
        return app(FindUserRealEstateHandler::class);
    }

    public function handle()
    {
        $this->getFindUserRealEstateHandler()->handle(
            $this->user,
        );
    }}
