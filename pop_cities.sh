#!/usr/bin/env bash
awk -F" " 'NR > 1 {print $3}' cities.txt | sort | uniq -c | sort -rn | awk -F " " '{print $2}' | head -3