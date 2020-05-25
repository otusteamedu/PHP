# !/bin/bash
awk -F:" " '{ if (NR > 1) print $0 | "sort -k3 | uniq -c | sort -nr | head -n3" }' cities.txt