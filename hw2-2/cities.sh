#!/bin/bash
awk -F " " 'NR > 1 { print $3}' data.txt |
sort |
uniq -c |
sort -nr |
awk -F " " '{ print $2}' |
head -3