<?php

while ($line = trim(fgets(STDIN))) {
    if (count(explode(' ', $line)) > 1) {
        $maybeCommit = explode(' ', $line)[1];
    } else {
        echo "Я не знаю, что вы хотели";
    }

    if ($maybeCommit === 'commit') {
        continue;
    }

    if (levenshtein($maybeCommit, 'commit') < 5) {
        echo "Наверное вы имели ввиду commit";
    } else {
        echo "Я не знаю, что вы хотели";
    }
}