#!/bin/bash

awk 'NR > 1 {print $3}' table.txt | sort | uniq -c | sort -r | head -n3 | awk '{print $2}'
