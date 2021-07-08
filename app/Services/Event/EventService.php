<?php


namespace App\Services\Event;


use App\Models\Event;
use App\Services\Event\Repositories\IdentityMap;
use App\Services\Event\Repositories\ISearchEventRepository;
use App\Services\Event\Repositories\IWriteEventRepository;


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


    public function getEventByCondition($params): Event
    {
        $conditions = $this->getParametersForCondition($params);
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
        $toSave['name'] = $params['name'] ?? "Событие добавленное";
        $toSave['priority'] = (int)$params['priority'] ?? 100;
        $toSave['conditions'] = $this->getParametersForCondition($params);
        return $toSave;
    }

    /**
     * Возвращает массив параметров param(n) и значений.
     * типа ['param1'=>1,'param2'=>5]
     *
     * @param $params
     * @return array
     */
    private function getParametersForCondition($params): array
    {
        //Берем все ключи, которые начинаются на param
        $result = array_filter($params, function($key) {
            return str_starts_with($key, 'param');
        }, ARRAY_FILTER_USE_KEY);
        //Возвращается массив с преобразованными строковыми значениями в числовые
        return array_map('intval', $result);
    }

}
