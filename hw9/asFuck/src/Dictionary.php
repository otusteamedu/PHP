<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace AsFuck;

class Dictionary
{
    public static function getDictionary(): array
    {
        return [
            'git' => [
                'commit' => [],
                'push' => [],
                'pull' => [
                    'origin' => []
                ]
            ]
        ];
    }
}