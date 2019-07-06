<?php

namespace App;

class Fuck implements CommandInterface
{
    private $subject;

    /**
     * @param string $subject проверяемая строка
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Если команда похожа на `php --version`, спрашивает подтверждение пользователя.
     * Если пользователь дает утвердительный ответ, то возвращает строку `php --version`,
     * если пользователь дает отрицательный ответ, то возвращает пустую строку.
     * @return string
     */
    public function execute()
    {
        if (preg_match('/p.{1,2}p --v.{3,5}n/', $this->subject)) {
            # Пишем вопрос в STDERR, поксольку STDOUT попадает на вход в eval
            fputs(STDERR, "Maybe you meant: \"php --version\"? (y/n)" . PHP_EOL);
            fscanf(STDIN, '%s', $answer);
            if ($answer === 'y') {
                return 'php --version';
            }
        }
        return '';
    }
}
