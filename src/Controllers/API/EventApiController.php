<?php

namespace Controllers\API;

use Controllers\RedisController;
use Exception;
use Helpers\ArraySort;
use Helpers\Validate;
use JsonException;
use Models\EventModel;
use Views\ApiJsonView;

class EventApiController extends ApiController
{
    public string $apiName = 'event';
    protected RedisController $redis;
    protected EventModel $eventModel;
    protected ApiJsonView $ApiJsonView;

    /**
     * EventApiController constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->redis = new RedisController();
        $this->eventModel = new EventModel();
        $this->ApiJsonView = new ApiJsonView();
    }

    /**
     * @throws JsonException
     */
    protected function indexAction(): void
    {
        $result = $this->eventModel->getAllEvent();
        $this->checkResult($result);
    }

    /**
     * @param array $result
     * @throws JsonException
     */
    private function checkResult(array $result): void
    {
        if (!empty($result)) {
            $this->ApiJsonView->response($result, 200);
        } else {
            $this->ApiJsonView->response(['No event found!'], 404);
        }
    }

    protected function viewAction(): void
    {

    }

    /**
     * @throws JsonException
     */
    protected function createAction(): void
    {
        if (Validate::validateEvent($this->formData)) {
            $this->eventModel->setPriority($this->formData['priority']);
            $this->eventModel->setConditions($this->formData['conditions']);
            if ($this->eventModel->saveEvent()) {
                $this->ApiJsonView->response(['Event is create!'], 200);
            }
        } else {
            $this->ApiJsonView->response(['error' => 'Failed create event. Check necessary fields.'], 404);
        }
    }

    /**
     * получить event по параметрам
     * @throws JsonException
     */
    protected function updateAction(): void
    {
        if (Validate::validateSearchEvent($this->formData)) {
            $arrAllEvent = $this->eventModel->getAllEvent();
            $arrKeyParams = array_keys($this->formData['params']);
            $arrEventSort = ArraySort::customMultiSort($arrAllEvent, 'priority');

            $isFinish = false;
            foreach ($arrEventSort as $eventKey => $eventData) {
                foreach ($arrKeyParams as $keyParam) {
                    if (in_array($this->formData['params'][$keyParam], $eventData['conditions'], true)) {
                        $this->ApiJsonView->response($this->eventModel->getEvent($eventKey), 200);
                        $isFinish = true;
                        break;
                    }
                }
                if ($isFinish) {
                    break;
                }
            }

            if (!$isFinish) {
                $this->ApiJsonView->response(['error' => 'No event found.'], 200);
            }
        } else {
            $this->ApiJsonView->response(['error' => 'Failed search event. Check necessary fields.'], 404);
        }
    }

    /**
     * @throws JsonException
     */
    protected function deleteAction(): void
    {
        session_destroy();
        $result = $this->redis->deleteAllEvent();
        $this->checkResult($result);
    }
}