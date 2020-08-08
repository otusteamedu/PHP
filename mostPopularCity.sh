#!/bin/bash

if ! [[ -f $1 ]] ; then
    echo 'Файл не существует. Укажите, пожалуйста, путь до таблицы с данными';
fi

tablePath=$1;
tableRowWithOutHead=$(($( wc -l "$tablePath" | awk '{print $1}') - 1));
tableDataSortByCity=$(tail -n "$tableRowWithOutHead" "$tablePath" | sort -k 3);
uniqCity=$( echo $"$tableDataSortByCity" | awk '{print $3}' | uniq );

for var in $uniqCity
do
 ((i+=1));
 arrUniqCity[$i]=$var;
done

echo '--------------------------------------';
echo 'Самые популярные города пользователей:';
echo '--------------------------------------';

for i in "${!arrUniqCity[@]}"; do
  numberCityUse=$( echo "$tableDataSortByCity" | awk "/${arrUniqCity[$i]}/ {print}" | wc -l)
  echo "${arrUniqCity[$i]} $numberCityUse";
done | sort -rk 2 | head -3 | awk '{print $1}'

echo '--------------------------------------';