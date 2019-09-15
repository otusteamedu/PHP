#!/usr/bin/env bash
awk -F'\t' 'NR>1 { print $3}' table | sort | uniq -c | sort -r | head -3 | awk '{ print $2 }'
