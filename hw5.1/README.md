Для работы с историей команд будем использовать файл ~/.bash_history

Используем  переменную $PROMPT_COMMAND,
чтобы сохранять команды сразу после выполнения
Добавьте следующую строку в файл ~/.bashrc, 
если переменная $PROMPT_COMMAND не была задана ранее:
PROMPT_COMMAND='history -a'
Добавьте следующую строку, 
если переменная $PROMPT_COMMAND уже была задана:
PROMPT_COMMAND='$PROMPT_COMMAND; history -a'