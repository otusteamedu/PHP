#!/usr/bin/env bash

pattern='^[0-9]+$'

if [[ $# -ne 2 ]]; then
   echo "Ошибка: количество аргументов больше 2" >&2;
   exit 1
fi

if ! [[ $1 =~ $pattern ]] || ! [[ $2 =~ $pattern ]];
then
   echo "Ошибка: невалидные входные данные" >&2;
   exit 1
fi

echo $(($1 + $2))
