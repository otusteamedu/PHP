#!/bin/bash
awk -F'\t' 'NR>1 {print $3}' cities | sort | uniq -c | sort -nrk 1 | head -3 | awk '{print $2}'
