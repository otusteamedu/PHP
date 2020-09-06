## Bash-скрипт суммирования двух чисел

Для запуска скрипта необходимо выполнить команду `./sum.sh value1 value2`

Например, `./sum.sh 10 -1.11`.

## Утилиты командной строки

Предположим, что таблица пользователей хранится в текстовом файле `users.txt`, тогда команда для выбора 3 наиболее популярных городов будет выглядеть следующим образом: 

`tail -n +2 users.txt | awk '{print $3}' | sort | uniq -c | sort -r | awk '{print $2}' | head -n3`
