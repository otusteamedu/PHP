#!/bin/bash
tail -n+2 city.txt | awk -F" " '{ city[$3]++ } END{ for (i in city) print city[i], " " i }' | sort -nr | head -n 3
exit 0
