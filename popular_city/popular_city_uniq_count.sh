#!/bin/bash
# Данный скрипт выбирает столбец через awk и подсчет городов выполняется утилиту uniq с ключом -с
awk '{print $3}' city.txt | sort | uniq -c | sort -r | head -3

