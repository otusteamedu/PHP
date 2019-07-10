<?php
$weights = [
['1', '2', 4],
['2', '3', 15],
['3', '6', 1],
['1', '4', 17],
['2', '5', 6],
['3', '5', 10],
['4', '5', 6],
['4', '6', 12],
['4', '7', 4],
['5', '6', 8],
['6', '9', 9],
['7', '8', 6],
['8', '9', 5],
['8', '10', 11],
['9', '10', 4],
['10', '11', 7],
['10', '12', 2],
['11', '12', 3],
];

$points = [
    '1' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '2' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '3' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '4' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '5' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '6' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '7' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '8' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '9' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '10' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '11' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
    '12' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
];

//++dbg
// $weights = [
//     ['1', '2', 1],
//     ['2', '3', 2],
//     ['1', '3', 5],
//     // ['1', '4', 1],
//     // ['4', '3', 1],
// ];

// $points = [
//     '1' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
//     '2' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
//     '3' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
//     // '4' => ['distanceToPoint' => PHP_INT_MAX, 'isVisited' => false],
// ];
//--dbg

function getDistanceBetweenNeighbors(string $from, string $to, $weights) {
    foreach($weights as $weight) {
        if(($weight[0] === $from && $weight[1] === $to)
        || ($weight[1] === $from && $weight[0] === $to)) {

            return $weight[2];
        }
    }

    return false;
}

function doDijkstra(string $from, array $points, array $weights) {
    $visitedPoints = [];
    $isAllPointsVisited = false;
    $points[$from]['distanceToPoint'] = 0;
    // $points[$from]['isVisited'] = true;
            //++dbg
        print_r($points);
            $i = 1;
            //--dbg
    while(!$isAllPointsVisited) {
        $isAllPointsVisited = true;
        $pointWithTheLeastDistanceTo = ['', PHP_INT_MAX];
        // Проверям есть ли непосещенные точки и выбираем с наименьшим расстоянием   
            //++dbg
            echo 'main cycle start: ' . $i . PHP_EOL;
            //--dbg
        foreach($points as $name => $pointData) {      
            //++dbg
            echo 'point name: ' . $name . ', ddata: ';
            var_dump($pointData);
            echo PHP_EOL;
        //--dbg
            if(!$pointData['isVisited']) {
                if($pointData['distanceToPoint'] < $pointWithTheLeastDistanceTo[1]
                ) {
                    $pointWithTheLeastDistanceTo[0] = $name;
                    $pointWithTheLeastDistanceTo[1] = $pointData['distanceToPoint'];
                }
            }
            
            //++dbg
            echo 'Least distance point: ' . $pointWithTheLeastDistanceTo[0] . ', distance: ' . $pointWithTheLeastDistanceTo[1] . PHP_EOL;
        //--dbg
        }
            //++dbg
            echo 'Selected point: ' . $pointWithTheLeastDistanceTo[0] . ', distance: ' . $pointWithTheLeastDistanceTo[1] . PHP_EOL;
            //--dbg
        // Пометим посещенной минимальную и добавим в массив посещенных
        foreach($points as $name => &$pointData) {
            if($name === $pointWithTheLeastDistanceTo[0]) {
                $pointData['isVisited'] = true;
                $visitedPoints[] = $name;
                break;
            }
        }
        unset($pointData);
        reset($points);

        // Пересчитываем расстояние ближайших точек
        foreach($points as $name => &$pointData) {
            // Пересчитываем расстояния 
            if(!$pointData['isVisited']) {
                $isAllPointsVisited = false;
                $distance = getDistanceBetweenNeighbors($pointWithTheLeastDistanceTo[0], $name, $weights);
                if($distance) {
                    if($pointData['distanceToPoint'] > $pointWithTheLeastDistanceTo[1] + $distance) {
                        $pointData['distanceToPoint'] = $pointWithTheLeastDistanceTo[1] + $distance;
                    }
                }
            }
        }
        unset($pointData);

        //++dbg
        print_r($points);
         echo 'main cycle end: ' . $i . PHP_EOL;
         $i++;
        //--dbg
    }

    echo '=================================================================' . PHP_EOL . PHP_EOL;
    echo 'Distance from point ' . $from . ' to point...' . PHP_EOL;

    foreach ($points as $name => $data) {
        echo $name . ' is ' . $data['distanceToPoint'] . PHP_EOL;
    }
}

doDijkstra('1', $points, $weights);