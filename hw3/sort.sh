#!/bin/bash
awk '{if ( NR > 1) print $3 }' table.txt | sort -d |uniq -ci |sort -dr | head -3 | awk '{print $2}'
