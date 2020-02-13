#!/bin/bash

awk 'NR > 1 {print $3}' table.txt | sort | uniq -c | sort -nr | head -n3 | awk '{print $2}'
