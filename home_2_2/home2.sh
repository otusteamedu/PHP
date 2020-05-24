#!/bin/bash

# Скрипт вывода самых популярных городов

# Количество попыток
maxCitiesList=3

# Получаем отсортированный лист
sortedList=$(tail -n +2 ./cities.txt |  awk '{print $3}'| sort)

# Получаем повторяющиеся города в порядке уменьшения вхождений
cities=$(echo "$sortedList" | uniq -dc | sort -rn) 

# Получаем количество найденных городов
counter=$(echo "$cities" | wc -l)

# Если городов меньше, чем в мин. кол-во
if (($counter <= $maxCitiesList));
then    

    # то добавляем первый из уникальных
    otherCities=$(echo "$sortedList" | uniq -uc | head -$(("$maxCitiesList" - "$counter"))) 
fi

# Выводим результат
echo "Самые популярные города:"
echo -e "$cities\n$otherCities" 
