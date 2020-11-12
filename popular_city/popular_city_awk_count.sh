#!/bin/bash
#Данный скрипт выполняет подсчет городов через awk.
awk '{a[$3]++}END{for(city_name in a) {print a[city_name], city_name}}' city.txt | sort -rk1 | head -3
