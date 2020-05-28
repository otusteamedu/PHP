#!/bin/bash
awk -F " " 'FNR == 1 {next} {print $3}' ./cities.txt | sort | uniq -c | sort -r | head -n 3
