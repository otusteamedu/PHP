<?php


namespace App\Services\Event;


use App\Models\Event;
use App\Services\Event\Repositories\ISearchEventRepository;
use App\Services\Event\Repositories\IWriteEventRepository;
use Illuminate\Support\Collection;


class EventService
{
    /**
     * Указатель на объект для внесения изменений в репозиторий
     * @var IWriteEventRepository
     */
    private IWriteEventRepository $writeEventRepository;

    /**
     * Указатель на объект для поиска данных в репозитории
     * @var ISearchEventRepository
     */
    private ISearchEventRepository $searchEventRepository;

    /**
     * EventService constructor.
     * @param IWriteEventRepository $writeEventRepository
     * @param ISearchEventRepository $searchEventRepository
     */
    public function __construct(
        IWriteEventRepository $writeEventRepository,
        ISearchEventRepository $searchEventRepository
    )
    {
        $this->writeEventRepository = $writeEventRepository;
        $this->searchEventRepository = $searchEventRepository;

    }

    /**
     * Удаляет Событие из репозитория по имени
     *
     * @param string $name
     * @return int
     */
    public function delete(string $name): int
    {
        return $this->writeEventRepository->delete($name);
    }

    /**
     * Удаляет все события из репозитория
     */
    public function deleteAll()
    {
        $this->writeEventRepository->deleteAll();
    }

    /**
     * Создает новое событие в репозитории
     *
     * @param $data
     * @return int
     */
    public function create($data): int
    {
        $correctData = $this->prepareParametersToSave($data);
        return $this->writeEventRepository->create($correctData);
    }

    /**
     * Возвращает набор всех событий из репозитория
     *
     * @return Collection
     */
    public function getEvents(): Collection
    {
        return $this->searchEventRepository->getEvents();
    }

    /**
     * Возвращает событие по условию из репозитория
     *
     * @param $params
     * @return Event
     */
    public function getEventByCondition($conditions): ?Event
    {
        return $this->searchEventRepository->getEventByCondition($conditions);
    }


    /**
     * Возвращает подготовленный набор параметров для записи
     *
     * @param array $params
     * @return array
     */
    private function prepareParametersToSave(array $params): array
    {
        $toSave['name'] = $params['name'] ?? "Event Added";
        $toSave['priority'] = (int)$params['priority'] ?? 100;
        $toSave['conditions'] = $params['conditions'] ?? [];
        return $toSave;
    }

}
