#!/bin/bash
awk '!(NR<=1) {print $3}' users.txt | sort | uniq -c | sort -r | head -3
