#!/bin/bash

awk 'NR == 1 {next} {print $3}' users.txt | sort | uniq -c | sort -k1nr -k2 | head -n 3
