#!/usr/bin/env bash

awk -F" " 'NR == 1 {next} {print $3}' cities.txt | sort | uniq -c | sort -r | head -n 3
