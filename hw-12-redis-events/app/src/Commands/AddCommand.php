<?php

namespace App\Commands;

use App\Models\DTO\EventDTO;
use App\Storage\Storage;
use App\Validators\EventDTOValidator;

class AddCommand implements CommandInterface
{
    public function execute (array $params): string
    {
        $id         = time();
        $priority   = intval($params['priority'] ?? 0);
        $conditions = $params['conditions'] ?? [];
        $event      = strval($params['event'] ?? '');

        $eventDTO = new EventDTO($id, $priority, $conditions, $event);

        if (EventDTOValidator::validate($eventDTO) === false) {
            return json_encode(
                [
                    'result' => 'error',
                    'msg'    => 'bad event params',
                ]
            );
        }

        $insertResult = Storage::getInstance()->getStorage()->store($eventDTO);

        if ($insertResult !== true)
        {
            return json_encode(
                [
                    'result' => 'error',
                    'msg'    => 'database store error',
                ]
            );
        }

        return json_encode(
            [
                'result' => 'success',
                'msg'    => 'OK',
            ]
        );
    }
}