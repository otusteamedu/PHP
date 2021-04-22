Пример использования:

index.php принимает первым аргументом название команды, которую нужно выполнить
- analyse
- statistics
- top

Первая команда ищет youtube канал по второму переданному параметру (id канала)

Вторая собирает статистику по каналу

Третья получает топ каналов (критерии - соотношение лайков к дизлайкам)

php index.php analyse UCY03gpyR__MuJtBpoSyIGnw

php index.php statistics UCY03gpyR__MuJtBpoSyIGnw

php index.php top 5
