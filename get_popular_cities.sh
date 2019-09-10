#!/bin/bash
awk 'NR >1 { print $3 }' city | sort | uniq -c | sort -rn | head -3 | awk '{ print $2}'