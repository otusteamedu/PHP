#!/bin/bash
awk -F" " 'NR>1 {print $3}' city.txt | sort | uniq -c | sort -nr | head -3 | awk -F" " '{print $2}'
exit 0
