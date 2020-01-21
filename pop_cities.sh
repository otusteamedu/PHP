#!/bin/bash
cat table.txt | awk 'NR>1 {print $3}'| sort | uniq -c | sort -k1 -ru | awk '(NR>=1)&&(NR<=3) {print $2}'
