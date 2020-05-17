# !/bin/bash

file=cities.txt

cat cities.txt | tail -n $(($(wc -l)-1)) cities.txt | awk -F" " '{print $3}' | sort | uniq -c | sort -nr | head -n 3

exit 1;