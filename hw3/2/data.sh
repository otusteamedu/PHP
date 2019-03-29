#!/bin/bash
#

cat file.txt | sed 1d | awk '{print $3}' | sort | uniq -c | sort -rnk1 | head -n 3 | awk '{print $2}'