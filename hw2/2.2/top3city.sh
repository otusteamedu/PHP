#!/usr/bin/env bash

file=$1
# базовая проверка файла
if [[ ! -f $file ]]
then
    echo "Файл не существует"
    exit 1
elif [[ ! -r $file ]]
then
    echo "Файл не доступен для чтения"
    exit 1
elif [[ ! -s $file ]]
then
    echo "Файл пуст"
    exit 1
fi

# убираем лишние колонки
awkPrepCommands='
{
if (NR > 1)
print $3 " " $2
}
';
# считаем количество городав в строках
awkCalcCommands='
{
if (! prevCity) {
    prevCity=$1
    cityCount=1
} else if (prevCity == $1) {
    cityCount+=1
} else {
    print prevCity " " cityCount
    cityCount=1
}
prevCity=$1
}
END{
print prevCity " " cityCount
}
';
# после применения uniq и sort подсчета количества городов
# реверсивно сортируем по количеству и выводим три популярных
awk "$awkPrepCommands" "$file" | uniq | sort | awk "$awkCalcCommands" | sort -r -n -k 2 | head -n 3

exit 0