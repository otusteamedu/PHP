#!/bin/bash
awk -F " " '{ print $3}' $1 | sort | uniq -c | sort -r | head -3