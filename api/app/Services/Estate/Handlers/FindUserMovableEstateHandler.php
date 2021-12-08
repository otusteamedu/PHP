<?php
/**
 * Description of FindUserMovableEstateHandler.php
 * @copyright Copyright (c) valyakin.ru
 * @author    Vladimir Valyakin <vladimir@valyakin.ru>
 */

declare(strict_types=1);

namespace App\Services\Estate\Handlers;

use App\Models\User;
use App\Services\Estate\Repositories\EstateRepositoryInterface as EstateRepository;
use Illuminate\Support\Facades\Log;

class FindUserMovableEstateHandler
{
    /**
     * @var EstateRepository
     */
    private EstateRepository $estateRepository;

    /**
     * @param EstateRepository $estateRepository
     */
    public function __construct(
        EstateRepository $estateRepository
    )
    {
        $this->estateRepository = $estateRepository;
    }

    /**
     * @param User $user
     */
    public function handle(User $user): void
    {
        Log::info('User has movable estate:', $this->estateRepository->findMovableEstate($user)->toArray());
    }

}
