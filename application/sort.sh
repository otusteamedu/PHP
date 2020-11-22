#!/bin/sh

 sed '1d' "$1" | awk '{print $3}' | sort | uniq -c | sort  -k1nr,2 | head -n 3
