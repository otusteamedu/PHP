<?php

declare(strict_types=1);

namespace App\Validators;

class EventValidator
{
    public function isJson($str)
    {
        $json = json_decode($str);

        return $json !== false && !is_null($json) && $str != $json;
    }

    /**
     * @throws \Exception
     */
    public function validateEvent($event): string
    {
        if (!$this->isJson($event)) {
            throw new \Exception("Event isn't valid JSON");
        }

        $newEvent = json_decode($event, true);
        $badFields = [];

        if (empty($newEvent['priority'])) {
            $badFields[] = "Нет поля 'priority'";
        }
        if (empty($newEvent['conditions'])) {
            $badFields[] = "Нет поля 'conditions'";
        } else {
            foreach ($newEvent['conditions'] as $paramKey => $paramValue) {
                if (empty($paramValue)) {
                    $badFields[] = "Пустое поле {$paramKey}";
                }
            }
        }
        if (empty($newEvent['event'])) {
            $badFields[] = "Нет поля 'event'";
        }
        if (empty($newEvent['event']['name'])) {
            $badFields[] = "Пустое поле 'event.name'";
        }

        if (!empty($badFields)) {
            $errorMsg = implode('; ', $badFields);
            throw new \Exception($errorMsg);
        }

        $validEvent['priority'] = $newEvent['priority'];
        $validEvent['conditions'] = $newEvent['conditions'];
        $validEvent['event']['name'] = $newEvent['event']['name'];

        return json_encode($validEvent);
    }

    /**
     * @throws \Exception
     */
    public function validateQuery($query): array
    {
        if (!$this->isJson($query)) {
            throw new \Exception("Query isn't valid JSON");
        }
        $arQuery = json_decode($query, true);
        $badFields = [];

        if (empty($arQuery['params'])) {
            $badFields[] = "Нет поля 'params'";
        } else {
            foreach ($arQuery['params'] as $paramKey => $paramValue) {
                if (empty($paramValue)) {
                    $badFields[] = "Пустое поле {$paramKey}";
                }
            }
        }

        return $arQuery['params'];
    }
}