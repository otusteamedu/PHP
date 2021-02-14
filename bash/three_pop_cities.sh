#!/usr/bin/bash

awk 'NR > 1 {print $3}' table.txt  | sort | uniq -c | sort -k1,1nr -k2,2 | awk '{ print $2 }' | head -n 3