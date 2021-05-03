<?php

namespace Src\Services;

use Klein\Request;
use Ramsey\Uuid\Uuid;
use Src\DTO\EventDto;
use Src\Exceptions\DataBaseApiException;
use Src\Messages\Responser;
use Src\Repositories\Repository;
use Src\Validators\EventDtoValidator;

/**
 * Class EventService manage requests for repository
 */
class EventService
{
    /**
     * Insert data into DB by request
     *
     * @param \Klein\Request $request
     * @return string
     * @throws DataBaseApiException
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
                $repository = (new Repository())->getRepository();
                $repository->save($eventDto);
            } catch (DataBaseApiException $exception) {
                throw new DataBaseApiException($exception->getMessage(), $exception->getCode(), $exception);
            }
            return Responser::responseOk();
        }
    }

    /**
     * @return string
     * @throws \Src\Exceptions\DataBaseApiException
     */
    public function deleteData(): string
    {
        $repository = (new Repository())->getRepository();
        $repository->deleteAll();

        return Responser::responseOk();
    }

    /**
     * @return string
     */
    public function getListData(): string
    {
        $repository = (new Repository())->getRepository();
        return $repository->getListEvents();
    }

    /**
     * Search data by user request params
     * @param \Klein\Request $request
     * @return string
     * @throws DataBaseApiException
     * @throws \Exception
     */
    public function searchData(Request $request): string
    {

        $params = $request->paramsGet()->all();

        if (!is_array($params) || empty($params)) {
            Responser::responseFailData('wrong input params');
        }

        $repository = (new Repository())->getRepository();
        $result = $repository->search($params);

        if (!$result) {
            Responser::responseDataBaseFailed('search result is null or search is failed');
        }

        return $result;
    }
}
