<?php
declare(strict_types=1);

$n = 12;

$input = json_decode(file_get_contents("Dijkstra.json"));
$matrix = [$n][$n];
for ($i = 1; $i <= $n; $i++) {
    for ($j = 1; $j <= $n; $j++) {
        $matrix[$i][$j] = 0;
    }
}
foreach ($input as $i) {
    $matrix[$i[0]][$i[1]] = $i[2];
}

$d = []; //длина кратчайшего пути из до вершины []
$v = []; //множество посещённых вершин

$d[1] = 0;
$v[1] = 1;
for ($i = 2; $i <= $n; $i++) {
    $d[$i] = 10000;
    $v[$i] = 1;
}

do {
    $min = 10000;
    $minindex = 10000;
    for ($i = 1; $i <= $n; $i++) {
        // Если вершину ещё не обошли и вес меньше min
        if (($v[$i] == 1) && ($d[$i] < $min)) {
            // Переприсваиваем значения
            $min = $d[$i];
            $minindex = $i;
        }
    }

// Добавляем найденный минимальный вес
// к текущему весу вершины
// и сравниваем с текущим минимальным весом вершины
    if ($minindex != 10000) {
        for ($i = 1; $i <= $n; $i++) {
            if ($matrix[$minindex][$i] > 0) {
                $temp = $min + $matrix[$minindex][$i];
                if ($temp < $d[$i]) {
                    $d[$i] = $temp;
                }
            }
        }
        $v[$minindex] = 0;
    }

} while ($minindex < 10000);

print_r("\nКратчайшие расстояния до вершин: " . PHP_EOL);
for ($i = 1; $i<=$n; $i++) {
    print_r("Вершина " . $i . " - " . $d[$i] . PHP_EOL);
}