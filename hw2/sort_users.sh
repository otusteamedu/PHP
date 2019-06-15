#!/bin/bash
awk 'NR>1 {print $3}' users.txt | sort | uniq -c | sort -nr | head -3 | awk '{print $2}'
