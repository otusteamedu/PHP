<?php

namespace Src\Services;

use Klein\Request;
use Ramsey\Uuid\Uuid;
use Src\DTO\EventDto;
use Src\Exceptions\DataBaseException;
use Src\Messages\Responser;
use Src\Repositories\RedisRepository;
use Src\Repositories\Repository;
use Src\Validators\EventDtoValidator;

/**
 * Class EventService
 *
 * @package Src\Services
 */
class EventService
{
    /**
     * @param Request $request
     *
     * @return string
     * @throws \Exception
     */
    public function insertData(Request $request): string
    {
        $params = \GuzzleHttp\json_decode($request->body(), true);

        $uid = Uuid::uuid4();
        $event = ($params['event'] ?? '');
        $priority = ($params['priority'] ?? 0);
        $conditions = $params['conditions'] ?? [];

        $eventDto = new EventDto($uid, $priority, $conditions, $event);

        if (EventDtoValidator::isValidate($eventDto)) {
            try {
                /** @var RedisRepository $repository */
                $repository = (new Repository())->getRepository();
                $repository->save($eventDto);
            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }
            return Responser::responseOk();
        }
    }

    /**
     * @return string
     * @throws \Src\Exceptions\DataBaseException
     */
    public function deleteData(): string
    {
        /** @var RedisRepository $repository */
        $repository = (new Repository())->getRepository();
        $repository->deleteAll();

        return Responser::responseOk();
    }

    /**
     * @return string
     */
    public function getListData(): string
    {
        /** @var RedisRepository $repository */
        $repository = (new Repository())->getRepository();
        return $repository->getListEvents();
    }

    /**
     * @param \Klein\Request $request
     *
     * @return string
     * @throws DataBaseException
     * @throws \Exception
     */
    public function searchData(Request $request): string
    {

        $params = $request->paramsGet()->all();

        if (!is_array($params) || empty($params)) {
            Responser::responseFailData('wrong input params');
        }

        /** @var RedisRepository $repository */
        $repository = (new Repository())->getRepository();
        $result = $repository->search($params);

        if (!$result) {
            Responser::responseDataBaseFailed('search result is null or search is failed');
        }

        return $result;
    }
}
