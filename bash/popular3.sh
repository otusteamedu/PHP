#!/bin/bash
awk '{ if(NR>1) print $3 }' table.txt | sort | uniq -c | sort -nr | head -n 3 | awk '{ print $2 }'
