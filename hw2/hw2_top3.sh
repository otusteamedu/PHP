# !/bin/bash
awk 'FNR>1' $1 | awk -F'\t' '{print $3}' | sort | uniq -c | sort -r | awk -F' ' '{print $2}' | head -n3;
