#!/bin/bash
awk '{$1=""; $2=""; $4=""; sub("  ", " "); print}' cities.txt | sed '1d' | sort | uniq -c | sort -r | awk '{$1=""; sub("  ", " "); print}' | head -n3