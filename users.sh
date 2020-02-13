#!/bin/bash
awk -F' ' '/^[0-9]/{print $3}' ./users.txt | sort | uniq -c | sort -nr | head -n3
exit 0