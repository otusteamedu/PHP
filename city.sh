#!/usr/bin/env bash

awk -F'\t' 'NR>1 { print $3}' users-table | sort | uniq -c | sort -nr | head -3
