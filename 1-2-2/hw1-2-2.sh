#!/usr/bin/env bash

awk -F " " 'NR ==  1 {next} {print $3}' hw1-2-2.txt|sort|uniq -c|sort -r |head -3
