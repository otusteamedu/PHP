<?php

return [
    '/' => [\Src\Http\GameController::class, 'index'],
    '/action' => [\Src\Http\GameActionController::class, 'index']
];