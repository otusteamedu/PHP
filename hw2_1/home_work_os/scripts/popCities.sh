#! /bin/bash
# awk 'NR>1 {print $3}' cities.txt | sort | uniq -c | sort
awk 'NR>1 {print $3}' cities.txt | sort | uniq -c | sort -r | head -n 3