#!/bin/bash

filename=$1

cat $filename | awk -F" " 'NR > 1{ print $3 }' | sort | uniq -c | sort -r | head -n3 | awk '{ print $2 }'