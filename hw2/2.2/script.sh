#! /bin/bash

awk '{print $3}' text.txt | awk 'FNR>1' | sort | uniq -c | sort -rn | awk 'NR <= 3'
