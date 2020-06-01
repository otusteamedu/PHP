#!/bin/bash
awk '{print $3}' list.txt | sort -n | uniq -d  | sort -nr | head -n 3
