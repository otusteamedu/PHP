<?php
$log = file('/Users/khutornaya/.bash_history', FILE_IGNORE_NEW_LINES);
$input = array_pop($log);

// массив сверяемых слов
$commands  = array('git commit','git diff','git stash','git merge',
                'git checkout','git push','git clean','git reset','git branch');

// кратчайшее расстояние пока еще не найдено
$shortest = -1;
// проходим по словам для нахождения самого близкого варианта
foreach ($commands as $command) {
    $lev = levenshtein($input, $command);
    if ($lev == 0) {
        // это ближайшее слово (точное совпадение)
        $closest = $command;
        $shortest = 0;
        // выходим из цикла - мы нашли точное совпадение
        break;
    }
    // если это расстояние меньше следующего наименьшего расстояния
    // ИЛИ если следующее самое короткое слово еще не было найдено
    if ($lev <= $shortest || $shortest < 0) {
        // устанивливаем ближайшее совпадение и кратчайшее расстояние
        $closest = $command;
        $shortest = $lev;
    }
}
echo "Вы ввели: $input\n";
if ($shortest == 0) {
    echo "Найдено точное совпадение: $closest\n";
} else {
    echo "Вы не имели в виду: $closest?\n";
}