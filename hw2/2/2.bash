#!/bin/bash
cat table.txt | awk '$3!="city" {print $3}' | sort |  uniq -c | sort -nr | head -n 3 | awk '{print $2}'
