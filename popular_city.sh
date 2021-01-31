#!/usr/bin/env bash

awk 'NR>1 {print $3}' "$1" | sort | uniq -c | sort -r | head -n 3 | awk '{print $2}'
