#!/usr/bin/env bash

awk -F "\t" 'NR>1{print $3}' ./users.txt | sort -r | uniq -c | sort -k 1nr | awk -F " " 'FNR<=3{print $2}'