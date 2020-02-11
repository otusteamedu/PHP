#!/bin/bash

check_arg() {
    if [[ ! -n "$1" ]]
        then
            echo "ОШИБКА: не передан обязательный аргумент"
            exit 1
    fi
    if [[ ! $1 =~ ^-?[0-9]+$ ]]
        then
            echo "ОШИБКА: аргумент должен быть целым числом"
            exit 1
    fi
}

check_arg $1
check_arg $2

expr $1 + $2
