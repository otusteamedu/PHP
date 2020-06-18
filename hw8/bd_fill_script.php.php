<?php

/**
 * $id - ++
 * $time - из массива
 * $hall_id - 1...15
 * $free_place random(1:20)
 * $film_id - из массива
 * 
 * Результат около 25000 значений...
 */

$id = 3;
$tickid = 2;
$time = ['9:00:00', '11:00:00', '13:00:00', '15:00:00', '17:00:00', '19:00:00', '21:00:00',];
$film_id = [1, 2, 3, 4, 5, 6, 10, 11];
$fdate = ['2020-06-01', '2020-06-02', '2020-06-03', '2020-06-04', '2020-06-05', '2020-06-06', '2020-06-07', '2020-06-08',];
$j = 0;
foreach ($film_id as $fid) {        // цикл по фильмам
    $did = $fdate[$j++];
    for ($i = 1; $i <= 15; $i++) {  // цикл по залам
        foreach ($time as $tid) {   // цикл по времени сеанса
            echo "INSERT INTO \"public\".\"session\" VALUES (" . ++$id . ", '{$did}', '{$tid}', {$i}, " . rand(0, 20) . ", {$fid}); <br>";
            $fin = rand(10, 50);
            for ($numplace = 0; $numplace < $fin; $numplace++) {  // цикл по билетам
                echo "INSERT INTO \"public\".\"ticket\" VALUES (" . ++$tickid . ", " . rand(250, 500) . ", {$id}); <br>";
            }
        }
    }
}

