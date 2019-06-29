<?php

echo 'Введите комманду...' . PHP_EOL;

// -- Слушаем пользовательский ввод
while ($cmd = trim(fgets(STDIN))) {
	// -- Проверяем нужно ли исправлять команду
	exec($cmd . ' 2>&1', $output, $result);

	$output = implode(' ', $output);

	if (0 === $result) {
		die($output . PHP_EOL);
	}
	// -- -- -- --

	$newCommand = getNewCommand($cmd, $output); // Получаем новую команду
	if ('' !== $newCommand) {
		$line = readline('Возможно вы имели ввиду:' . $newCommand . ' (Y/n)');
		if ('' === $line || 'Y' === $line || 'y' === $line) {
			die(shell_exec($newCommand));
		}
	}

	echo 'No fucks' . PHP_EOL;
	echo 'Введите комманду...' . PHP_EOL;
}
// -- -- -- --

/**
 * Получение новой команды.
 *
 * @param string $cmd    Строка команды
 * @param string $output Вывод, полученный при вводе
 *
 * @return string
 */
function getNewCommand($cmd, $output): string {
	$LEVINSHTEIN_DIFF = 5; // Максимальное значение, при котором поиск считается успешным

	// -- Делим команду по частям
	$commandParts = explode(' ', $cmd);
	if ('sudo' === $commandParts[0]) {
		unset($commandParts[0]);
	}

	if (count($commandParts) < 2) {
		return '';
	}
	// -- -- -- --

	// -- Проверяем на совпадение с 'git commit'
	$isMatch = $LEVINSHTEIN_DIFF >= levenshtein('git commit', $commandParts[0] . $commandParts[1]);
	if (false === $isMatch) {
		return '';
	}

	$newCommand = 'git commit';
	// -- -- -- --

	// -- Обрабатываем случай, когда пользователь неправильно указал имя файла(ов)
	if (false !== stripos($output, 'did not match any file(s) known to git')) {
		if (count($commandParts) < 3) {
			return $newCommand;
		}

		$filesList = scandir('./');
		for ($i = 2; $i < count($commandParts); $i++) {
			$shortest     = -1;
			$closestFile = $filesList[0];
			$searchName  = $commandParts[$i];
			foreach ($filesList as $file) {
				$lev = levenshtein($searchName, $file);

				if ($lev < $shortest || $shortest < 0) {
					$shortest    = $lev;
					$closestFile = $file;
				}
			}

			$newCommand .= ' ' . $closestFile;
		}
	}
	// -- -- -- --

	return $newCommand;
}
