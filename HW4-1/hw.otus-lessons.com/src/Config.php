<?php


namespace App;


class Config
{
    private static $config = [
        'route' => [
            'test' => [
                'controller' => 'base',
                'action' => 'index'
            ]
        ],
        'parseString' => [
            '/^(\(\))+$/',
//            '/a+$/',
        ]
    ];

    public static function getConfig()
    {
        return self::$config;
    }
}