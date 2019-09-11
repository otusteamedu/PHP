#!/usr/bin/env bash

#преобразовываем файл в столбец с городами
awk -f myscript.awk db.txt
#сортируем файл по числу вхождений и отрезаем 3 первых записи
sort cities.txt | uniq -c | sort -nr | head -n 3


