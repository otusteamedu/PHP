<?php


namespace App\Services\Events;


use App\Services\Events\Repositories\iEventRepository;
use App\Services\Events\Repositories\iEventSearchRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

class EventService
{
    private $repository, $searchRepository;

    public function __construct(iEventRepository $repository, iEventSearchRepository $searchRepository)
    {
        $this->repository = $repository;
        $this->searchRepository = $searchRepository;
    }

    public function add(array $data): void
    {
        $validator = \Validator::make($data, [
            'name'       => 'required',
            'conditions' => 'required|array',
            'priority'   => 'required|numeric|min:1'
        ])->stopOnFirstFailure(true);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        };
        $this->repository->add(collect($data)->only(['name', 'conditions', 'priority'])->toArray());
    }

    public function delete(string $name)
    {
        $this->repository->delete($name);
    }

    public function clear()
    {
        $this->repository->clear();
    }

    public function getEventByCondition($condition): ?array
    {
        return $this->searchRepository->getByCondition($condition);
    }

}
