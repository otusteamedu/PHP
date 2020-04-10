#!/bin/bash
tail -n+2 city.txt | awk -F" " '{ print $3 }' | sort | uniq -c | sort -nr | head -n 3
exit 0