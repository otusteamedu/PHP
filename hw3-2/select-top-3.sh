#!/bin/bash
if [ ! -f db.tsv ]; then
    echo DB file not found! >&2
    echo Create it with fixture.sh
    exit 1
fi

tail +2 db.tsv \
| awk '{count[$3]++} END {for (i in count) printf("%s\t%i\n", i, count[i])}' \
| sort -nrk2 \
| head -3
