#!/bin/bash
awk -F' ' '/^[0-9]/{print $3}' ./users.txt | sort | uniq -c | sort -r | head -n3
exit 0