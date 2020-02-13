#!/bin/bash

tail -n+2 database.txt | awk -F" " '{ print $3 }' | sort | uniq -c | sed 's/^\s*//' | sort -t " " -k1,1nr -k2,2

exit 0
