<?php

const ELEMENT_FACTORIES = [
    \Src\Factories\ZElementFactory::class,
    \Src\Factories\TElementFactory::class,
    \Src\Factories\OElementFactory::class,
    \Src\Factories\SElementFactory::class,
    \Src\Factories\LElementFactory::class,
    \Src\Factories\JElementFactory::class,
    \Src\Factories\IElementFactory::class,
];

const ELEMENT_COLORS = ['red', 'blue', 'green', 'yellow', 'gray'];

const LEVELS_CONFIG = [
    [
        'speed' => 1,
        'needScore' => 0,
    ],
    [
        'speed' => 2,
        'needScore' => 100,
    ],
    [
        'speed' => 3,
        'needScore' => 300,
    ],
    [
        'speed' => 4,
        'needScore' => 500,
    ],
    [
        'speed' => 5,
        'needScore' => 1000,
    ],
    [
        'speed' => 6,
        'needScore' => 3000,
    ],
    [
        'speed' => 7,
        'needScore' => 10000,
    ],
];

const PLAY_GROUND_SIZE = [30,10];

const SESSION_PLAY_KEY = 'play';

const SCORE_CALCULATORS_BY_ROWS = [
    1 => \Src\Services\Score\OneRowResetScoreCalculator::class,
    2 => \Src\Services\Score\TwoRowResetScoreCalculator::class,
    3 => \Src\Services\Score\ThreeRowResetScoreCalculator::class,
    4 => \Src\Services\Score\FourRowResetScoreCalculator::class,
];

const DEFAULT_ACTION = \Src\Actions\RedrawPlayGroundAction::class;

const RESET_ROWS_COUNT = 'reset_rows_count';
const RESET_ROWS_FROM = 'reset_rows_from';

const RESET_ROWS_EVENT = \Src\Events\RowResetEvent::class;

const EVENTS = [
    RESET_ROWS_EVENT,
];

const EVENT_SUBSCRIBERS = [
    RESET_ROWS_EVENT => [
        \Src\Subscribers\RiseUserScore::class,
        \Src\Subscribers\CheckPlayLevel::class,
        \Src\Subscribers\ClearPlayGround::class,
    ]
];

const MOVE_DOWN_ACTION = 'move_down';
const MOVE_RIGHT_ACTION = 'move_right';
const MOVE_LEFT_ACTION = 'move_left';
const NEXT_ELEMENT_ACTION = 'next_element';
const ROTATE_ACTION = 'rotate';
const DROP_ACTION = 'drop';

CONST ACTIONS = [
    MOVE_DOWN_ACTION => \Src\Actions\MoveDownAction::class,
    MOVE_RIGHT_ACTION => \Src\Actions\MoveRightAction::class,
    MOVE_LEFT_ACTION => \Src\Actions\MoveLeftAction::class,
    NEXT_ELEMENT_ACTION => \Src\Actions\NextElementAction::class,
    ROTATE_ACTION => \Src\Actions\RotateAction::class,
    DROP_ACTION => \Src\Actions\DropAction::class,
];