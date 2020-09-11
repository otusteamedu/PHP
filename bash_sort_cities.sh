#!/bin/bash

awk -F" " '{ print $3 }' $1 | sort | uniq -c | sort -r | awk -F" " 'NR <= 3{ print $2 }'

