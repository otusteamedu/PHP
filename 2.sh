#!/bin/bash
#OTUS PHP-11-2019
cat 2.txt | awk '{print $3}' | sort | uniq -c | sort -rnk1 | head -n 3