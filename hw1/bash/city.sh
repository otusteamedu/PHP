#!/usr/bin/bash

tail -n+2 city.txt | awk '{print $3}' | sort | uniq -c | sort -nr | head -3

exit 0