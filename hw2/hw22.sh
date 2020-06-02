#!/bin/bash
awk 'NR>1{print "- " $3;next}' cites.txt | sort | uniq -c | sort -nr | head -3

#Вариант без использования uniq
awk 'NR>1{a[$3]++}END{for(i in a){print a[i] " - " i}}' cites.txt | sort -nr | head -3