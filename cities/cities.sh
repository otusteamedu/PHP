#!/bin/bash

# Скрипт вывода самых популярных городов

# Версия скрипта
VERSION="Version 0.0.1"

# Получение версии скрипта
function getVersion()
{
	echo ${VERSION}
	return 0
}

# Получение справки
function getHelp()
{

	cat <<'_EOF_'
    Скрипт выводит 3 самых популярных города из таблицы пользователей

    Внимание! Скрипт не проверяет структуру переданных данных!!!

    Использование:

    ./cities.sh [опции]

    Опции:

    -f, --file - путь до файла данных. Если не передано, данные ожидаются на стандартном вводе
    -n, --number-of-cities - количество выводимых городов. По умолчанию 3
    -h, --help - Показать данное руководство
    -v, --version - Выводит версию

_EOF_

	return 0

}

# Чтение ввода
function readInput()
{
    read input

    if [[ -z "$input" ]]
    then
        getResult "./~.tmp"
        rm -rf "./~.tmp"
        exit 0
    else
        echo ${input} >> ./~.tmp
        readInput
    fi
}

function getResult()
{
    sed '1d' ${1} | awk '{print $3}' | sort | uniq -c | sort  -k1nr,2 | head -n 3
}

if [[ $# -gt 0 ]]
then
    count=0

    while [[ -n "$1" ]]
    do
        if [[ "$1" = "--help" ]] || [[ "$1" = "-h" ]]
        then
            # Пользователь запросил справку
            getHelp
            exit 0
        elif [[ ${count} -eq 0 ]] && ( [[ "${1}" = "-v" ]] || [[ "$1" = "--version" ]] )
        then

             if  [[ -z "$2"  ]] && [[ ${count} -eq 0 ]]
             then
                # Пользователь запросил версию
                getVersion
                exit 0
             else
                # Помимо версии запросили еще что-то, а это непорядок
                echo "Неправильный набор параметров" >&2
                getHelp
                exit 1
             fi
        elif [[ "${1}" = "-f" ]] || [[ "$1" = "--file" ]]
        then

            if [[ -f ${2} ]]
            then
                getResult ${2}
                exit 0
            else
                echo "Ошибка получения данных из файла ${2}" >&2
                exit 1
            fi
        else
            echo "Неправильный набор параметров" >&2
            getHelp
            exit 1
        fi

        count=$(($count + 1))
        shift
    done

else
    readInput
fi
