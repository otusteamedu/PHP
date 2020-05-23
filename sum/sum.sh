#!/bin/bash

# Скрипт суммирования чисел

# Версия скрипта
VERSION="Version 0.0.2"

# Количество попыток ввода
inputCount=0

# Приглашение для ввода
message="Введите число"

# Массив валидных аргументов.
validArguments=()

# Получение справки
function getHelp()
{

	cat <<'_EOF_'
	Скрипт суммирует все числа, переданные в качестве аргументов

	При запуске без аргументов берет из стандартного ввода

	Использование:

	./sum.sh [число 1] [число 2] [опции]

	Опции:

	-h, --help - Показать данное руководство
	-v, --version - Выводит версию

_EOF_

	return 0

}

# Получение версии скрипта
function getVersion()
{
	echo ${VERSION}
	return 0
}

# Проверка аргумента на целое число
function checkArgument()
{
    localResult=$( echo "${1}" | grep -E '^([-+])?[[:digit:]]+([.])?[[:digit:]]+$' )
}

# Чтение ввода
function readInput()
{
    if [[ ${inputCount} -gt 1 ]] && [[ ${inputCount} -lt 3  ]]
    then
        message="${message}. Для вывода суммы введенных чисел введите = "
    fi

    read -p "${message}: " input

    if  [[ "$input" = "=" ]]
    then
        getResult
    elif [[ -z "$input" ]]
    then
    	# Без этой ветки при подаче на стандартный ввод строки, не оканчивающейся на =, скрипт впадает в бесконечный цикл
        getResult
    elif checkArgument ${input}
    then
        validArguments+=(${input})
        inputCount=${inputCount}+1
        readInput
    else
        echo "Аргумент ${input} не является допустимым числом будет проигнорирован" >&2
        inputCount=${inputCount}+1
        readInput
    fi
}

stringForBC='0'

# Получение результата
function getResult(){
    # Соединяем все валидные значения в строку для bc
    for t in ${validArguments[@]}; do
        stringForBC="${stringForBC}+(${t})"
    done

    echo ${stringForBC} | bc

    exit 0
}

# Обрабатываем параметры
# Помним, что -v, -h, --version, --help тоже попадают в переменные $1, $#

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
        else
            if checkArgument $1
            then
                validArguments+=($1)
            else
                echo "Аргумент ${1} не является допустимым числом и будет проигнорирован" >&2
            fi
        fi

        count=$(($count + 1))
        shift
    done

    # Если аргументов мало, сообщаем об ошибке
    # иначе выводим результат
    if [[ ${#validArguments[@]} -lt 1 ]]
    then
        echo "Неправильный набор параметров" >&2
        getHelp
        exit 1
    else
        getResult
    fi

else
    readInput
fi

