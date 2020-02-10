<?php declare(strict_types=1);

namespace Service;

class RedisKeyResolver
{
    public function resolveKey(array $params): string
    {
        $key = [];
        foreach ($params as $paramName => $paramValue) {
            $key[] = $paramName . '=' . $paramValue;
        }
        asort($key);

        return 'event:' . implode('&', $key);
    }
}
