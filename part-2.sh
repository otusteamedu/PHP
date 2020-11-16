#!/bin/bash
cat $1 | awk 'NR >1 { print $3 }' |  sort | uniq -c | sort -r | awk '{ print $2 }' | head -n 3