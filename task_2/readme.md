Анализ таблицы пользователей
Имеется таблица следующего вида:

id	user	city	phone<br />
1	test	Moscow	1234123<br />
2	test2	Saint-P	1232121<br />
3	test3	Tver	4352124<br />
4	test4	Milan	7990923<br />
5	test5	Moscow	908213<br />

Таблица хранится в текстовом файле.

Вывести на экран 3 наиболее популярных города среди пользователей системы, используя утилиты Линукса.

Подсказка: рекомендуется использовать утилиты uniq, awk, sort, head.


Решение:<br />
grep -wo '[[:alnum:]]\+' users.txt | sort | uniq -cdi | awk -F, 'NR==1, NR==3 {print $1}'<br />
grep -wo '[[:alpha:]-]\+' users.txt | sort | uniq -cdi | head -n 3