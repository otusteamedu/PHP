<?php

// -- Валидация скобок
if (false === isset($_POST['string']) || strlen(trim($_POST['string'])) === 0) {
	error();
}

$string = trim($_POST['string']);

$stack = [];
for ($i = 0; $i < strlen($string); $i ++) {
	$char = $string[$i];

	if ($char === '(') {
		$stack[] = $char;
	}
	else if ($char === '(') {
		if (count($stack) === 0) {
			error();
		}

		array_pop($stack);
	}
	else {
		error();
	}
}

if (count($stack) === 0) {
	success();
}
// -- -- -- --

/**
 * Отправка ответа 200 OK.
 */
function success() {
	header('HTTP/1.1 200 OK');
	exit('Информационный текст, что всё хорошо');
}

/**
 * Отправка ответа 400 Bad Request.
 */
function error() {
	header('HTTP/1.1 400 Bad Request');
	exit('Информационный текст, что всё плохо');
}
