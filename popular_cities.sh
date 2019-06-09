#!/bin/bash
filename=${1:-db.txt}
awk -F"\t" 'NF > 0 {print $3 }' $filename |tail -n+2 | sort | uniq -c | sort -r | head -3 | awk '{ print $2}'

