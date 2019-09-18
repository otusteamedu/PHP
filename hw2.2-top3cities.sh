#!/bin/bash
if [ ! $# -eq 1 ]
then
    echo "Использование: $0 [FILE]"
    echo ""
    echo "Выводит 3 наиболее популярных города среди пользователей системы."
    echo ""
    echo "В FILE необходимо передать таблицу в текстовом формате."
    echo "В качестве разделителей полей используются пробелы."
    echo "В первой строке таблицы должны содержаться заголовки столбцов."
    echo "Столбец с городами должен называться city."
    echo "Столбец city может находиться на любом месте относительно других столбцов."
    exit 0
fi

headers=($( head -1 $1 ))
cityIndex=0
for (( i = 0; i < ${#headers[*]}; i++ ))
do
    if [ ${headers[$i]} = "city" ]
    then
        cityIndex=$(( $i + 1 ))
        break
    fi
done

if [ $cityIndex -eq 0 ]
then
    "В файле $1 не содержится столбца city"
    exit 1
fi

tail -n+2 $1 | awk -v cityIndex=$cityIndex '{ sub("  ", " "); print $cityIndex }' | sort | uniq -c | sort -r | head -3