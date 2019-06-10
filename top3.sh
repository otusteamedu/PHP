#!/bin/bash
awk 'NR>1 {arr[$3]++}END{for (key in arr) { print key " " arr[key] }}' table.txt | sort -k2rn | head -3