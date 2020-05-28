#!/bin/bash
awk '{count[$3]++} END {for (city in count) print count[city], city}' $1 | sort -r | uniq | head -3