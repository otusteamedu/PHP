**Как использовать**

1)зайти в контейнер php-fpm через команду  docker-compose exec php-fpm bash
2)зайти в директорию public
3)запустить скрипть через команду php index.php

index.php принимает параметры

- analyze (id youtube каналов через запятую)
- statistics (id канала для получения статистики)
- top_n (получить топ n каналов по соотношению likes/dislikes);

пример:

php index.php analyze UCMcDsSeqS531-HKz6GiJgtA,UC2QJf0YXCH57FR588wQIaSg

php index.php statistics UCMcDsSeqS531-HKz6GiJgtA

php index.php ton_n 3
