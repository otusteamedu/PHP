#!/bin/bash
awk -F" " '{ print $3 }' data.txt | sed 1d | sort | uniq -c | sort -r | head -3
