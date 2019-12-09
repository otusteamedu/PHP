<?php

namespace App\Http\Requests\Event;

class SearchRequest extends AbstractEventRequest
{
    /**
     * @return array|null
     */
    public function conditions(): ?array
    {
        if (!$this->has('conditions')) {
            return null;
        }

        return $this->parseConditions($this->get('conditions'));
    }
}
