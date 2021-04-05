<?php

namespace App\Commands;

use App\Models\DTO\EventDTO;
use App\Validators\EventDTOValidator;

class AddCommand implements CommandInterface
{
    public function execute (array $params): string
    {
        $id         = time();
        $priority   = intval($params['priority'] ?? 0);
        $conditions = $params['conditions'] ?? [];
        $event      = strval($params['event'] ?? '');

        $event = new EventDTO($id, $priority, $conditions, $event);

        if (EventDTOValidator::validate($event) === false) {
            return json_encode(
                [
                    'result' => 'error',
                    'msg'    => 'bad event params',
                ]
            );
        }


    }
}